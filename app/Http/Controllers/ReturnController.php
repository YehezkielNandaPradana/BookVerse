<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ReturnRecord;
use App\Models\Fine;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReturnController extends Controller
{
    /**
     * Daftar pengembalian.
     */
    public function index(Request $request)
    {
        $returns = ReturnRecord::query()
            ->with(['borrowing.member.user', 'returnedBy'])
            ->when($request->filled('search'), fn ($q) => $q->whereHas('borrowing.member.user', fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            ))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('transaction.returns.index', compact('returns'));
    }

    /**
     * Cari transaksi peminjaman aktif untuk dikembalikan.
     */
    public function searchBorrowing(Request $request)
    {
        $request->validate(['keyword' => 'required|string|min:1']);

        $borrowings = Borrowing::with(['member.user', 'borrowingItems.bookCopy.book'])
            ->where('status', 'borrowed')
            ->whereHas('member.user', fn ($q) => $q->where('name', 'like', "%{$request->keyword}%"))
            ->orWhere('id', $request->keyword)
            ->limit(10)
            ->get();

        return response()->json($borrowings);
    }

    /**
     * Form pengembalian: tampilkan transaksi + hitung estimasi denda.
     */
    public function create(Borrowing $borrowing)
    {
        $lateDays = max(0, Carbon::now()->diffInDays($borrowing->due_date, false) * -1);
        $finePerDay = Setting::first()->fine_per_day ?? 0;

        return view('transaction.returns.create', [
            'borrowing'        => $borrowing->load('borrowingItems.bookCopy.book'),
            'late_days'        => $lateDays,
            'estimated_fine'   => $lateDays * $finePerDay,
        ]);
    }

    /**
     * Simpan pengembalian, hitung denda otomatis, update stok & status salinan.
     */
    public function store(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return back()->withErrors(['error' => 'Transaksi ini tidak dalam status dipinjam.']);
        }

        $validated = $request->validate([
            'note'              => 'nullable|string',
            'damaged_copy_ids'  => 'nullable|array',
            'damaged_copy_ids.*' => 'exists:book_copies,id',
            'lost_copy_ids'     => 'nullable|array',
            'lost_copy_ids.*'   => 'exists:book_copies,id',
        ]);

        $returnRecord = DB::transaction(function () use ($borrowing, $validated) {
            $finePerDay = Setting::first()->fine_per_day ?? 0;
            $lateDays = max(0, Carbon::now()->diffInDays($borrowing->due_date, false) * -1);
            $totalFine = $lateDays * $finePerDay;

            $damagedIds = $validated['damaged_copy_ids'] ?? [];
            $lostIds = $validated['lost_copy_ids'] ?? [];

            // Tambahan denda untuk buku rusak/hilang
            $totalFine += count($damagedIds) * config('library.fine_damaged', 25000);
            $totalFine += count($lostIds) * config('library.fine_lost', 100000);

            $returnRecord = ReturnRecord::create([
                'borrowing_id' => $borrowing->id,
                'returned_by'  => Auth::id(),
                'return_date'  => now(),
                'late_days'    => $lateDays,
                'total_fine'   => $totalFine,
                'note'         => $validated['note'] ?? null,
            ]);

            foreach ($borrowing->borrowingItems as $item) {
                $status = in_array($item->book_copy_id, $lostIds)
                    ? 'lost'
                    : (in_array($item->book_copy_id, $damagedIds) ? 'damaged' : 'available');

                $item->bookCopy->update(['status' => $status]);

                if ($status === 'available') {
                    $item->bookCopy->book->increment('available_stock');

                    // Cek antrian reservasi untuk buku ini
                    $this->notifyNextReservation($item->bookCopy->book_id);
                }
            }

            if ($totalFine > 0) {
                Fine::create([
                    'return_id'   => $returnRecord->id,
                    'amount'      => $totalFine,
                    'status'      => 'unpaid',
                    'description' => $lateDays > 0 ? "Denda keterlambatan {$lateDays} hari" : 'Denda kerusakan/kehilangan',
                ]);
            }

            $borrowing->update(['status' => 'returned']);

            Notification::create([
                'user_id' => $borrowing->member->user_id,
                'title'   => 'Pengembalian Diterima',
                'message' => $totalFine > 0
                    ? "Buku dikembalikan dengan denda Rp " . number_format($totalFine, 0, ',', '.')
                    : 'Buku berhasil dikembalikan, tidak ada denda.',
                'type'    => 'returns',
                'is_read' => false,
            ]);

            return $returnRecord;
        });

        return redirect()->route('transaction.returns.show', $returnRecord)
            ->with('success', 'Pengembalian berhasil disimpan.');
    }

    public function show(ReturnRecord $return)
    {
        $return->load(['borrowing.member.user', 'borrowing.borrowingItems.bookCopy.book', 'returnedBy', 'fine']);

        return view('transaction.returns.show', compact('return'));
    }

    /**
     * Cetak bukti pengembalian (PDF).
     */
    public function printReceipt(ReturnRecord $return)
    {
        $return->load(['borrowing.member.user', 'borrowing.borrowingItems.bookCopy.book', 'fine']);

        $pdf = \PDF::loadView('transaction.returns.receipt', compact('return'));

        return $pdf->stream("bukti-pengembalian-{$return->id}.pdf");
    }

    /**
     * Beri notifikasi ke anggota berikutnya dalam antrian reservasi.
     */
    private function notifyNextReservation(int $bookId): void
    {
        $reservation = Reservation::where('book_id', $bookId)
            ->where('status', 'waiting')
            ->orderBy('reservation_date')
            ->first();

        if ($reservation) {
            $reservation->update(['status' => 'ready']);

            Notification::create([
                'user_id' => $reservation->member->user_id,
                'title'   => 'Buku Siap Diambil',
                'message' => 'Buku yang Anda reservasi sudah tersedia, silakan ambil sebelum batas waktu habis.',
                'type'    => 'reservation',
                'is_read' => false,
            ]);
        }
    }
}
