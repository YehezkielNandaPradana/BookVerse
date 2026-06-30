<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingItem;
use App\Models\BookCopy;
use App\Models\Book;
use App\Models\Member;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Daftar peminjaman: filter status, search anggota/buku, pagination.
     */
    public function index(Request $request)
    {
        $borrowings = Borrowing::query()
            ->with(['member.user', 'librarian.user', 'borrowingItems.bookCopy.book'])
            ->when($request->filled('search'), fn ($q) => $q->whereHas('member.user', fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            ))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('transaction.borrowings.index', compact('borrowings'));
    }

    /**
     * Form peminjaman baru (pencarian buku + keranjang dilakukan via JS/AJAX).
     */
    public function create()
    {
        return view('transaction.borrowings.create', [
            'members' => Member::with('user')->where('status', 'active')->get(),
        ]);
    }

    /**
     * Cari buku/salinan via judul, ISBN, atau scan barcode (AJAX).
     */
    public function searchBook(Request $request)
    {
        $request->validate(['keyword' => 'required|string|min:1']);

        $books = Book::with(['authors'])
            ->where('status', 'active')
            ->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->keyword}%")
                  ->orWhere('isbn', 'like', "%{$request->keyword}%")
                  ->orWhere('barcode', $request->keyword);
            })
            ->limit(10)
            ->get()
            ->map(fn ($book) => [
                'id'               => $book->id,
                'title'            => $book->title,
                'isbn'             => $book->isbn,
                'available_copies' => $book->bookCopies()->where('status', 'available')->count(),
            ]);

        return response()->json($books);
    }

    /**
     * Cari salinan buku berdasarkan barcode scan langsung.
     */
    public function scanCopy(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);

        $copy = BookCopy::with('book')->where('barcode', $request->barcode)->first();

        if (! $copy) {
            return response()->json(['message' => 'Salinan buku tidak ditemukan.'], 404);
        }

        if ($copy->status !== 'available') {
            return response()->json(['message' => 'Salinan buku sedang tidak tersedia.'], 422);
        }

        return response()->json($copy);
    }

    /**
     * Simpan peminjaman beserta item (keranjang salinan buku).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'        => 'required|exists:members,id',
            'due_date'         => 'required|date|after:today',
            'note'             => 'nullable|string',
            'book_copy_ids'    => 'required|array|min:1',
            'book_copy_ids.*'  => 'exists:book_copies,id',
        ]);

        $maxBorrow = config('library.borrow_limit', 3);
        $activeCount = Borrowing::where('member_id', $validated['member_id'])
            ->where('status', 'borrowed')
            ->withCount('borrowingItems')
            ->get()
            ->sum('borrowing_items_count');

        if ($activeCount + count($validated['book_copy_ids']) > $maxBorrow) {
            return back()->withErrors(['error' => "Melebihi batas maksimal pinjam ({$maxBorrow} buku)."])->withInput();
        }

        $borrowing = DB::transaction(function () use ($validated) {
            $borrowing = Borrowing::create([
                'member_id'    => $validated['member_id'],
                'librarian_id' => Auth::user()->librarian?->id,
                'borrow_date'  => now(),
                'due_date'     => $validated['due_date'],
                'status'       => 'pending',
                'note'         => $validated['note'] ?? null,
            ]);

            foreach ($validated['book_copy_ids'] as $copyId) {
                $copy = BookCopy::lockForUpdate()->findOrFail($copyId);

                if ($copy->status !== 'available') {
                    throw new \RuntimeException("Salinan {$copy->copy_code} sudah tidak tersedia.");
                }

                BorrowingItem::create([
                    'borrowing_id'  => $borrowing->id,
                    'book_copy_id'  => $copy->id,
                ]);
            }

            return $borrowing;
        });

        return redirect()->route('transaction.borrowings.show', $borrowing)
            ->with('success', 'Peminjaman berhasil dibuat, menunggu persetujuan.');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['member.user', 'librarian.user', 'borrowingItems.bookCopy.book']);

        return view('transaction.borrowings.show', compact('borrowing'));
    }

    /**
     * Setujui peminjaman: ubah status salinan menjadi borrowed.
     */
    public function approve(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->withErrors(['error' => 'Status peminjaman tidak valid untuk disetujui.']);
        }

        DB::transaction(function () use ($borrowing) {
            $borrowing->update(['status' => 'borrowed']);

            foreach ($borrowing->borrowingItems as $item) {
                $item->bookCopy->update(['status' => 'borrowed']);
                $item->bookCopy->book->decrement('available_stock');
            }

            Notification::create([
                'user_id' => $borrowing->member->user_id,
                'title'   => 'Peminjaman Disetujui',
                'message' => "Peminjaman #{$borrowing->id} telah disetujui, jatuh tempo {$borrowing->due_date}.",
                'type'    => 'approval',
                'is_read' => false,
            ]);
        });

        return back()->with('success', 'Peminjaman disetujui.');
    }

    /**
     * Tolak peminjaman.
     */
    public function reject(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->withErrors(['error' => 'Status peminjaman tidak valid untuk ditolak.']);
        }

        $borrowing->update([
            'status' => 'cancelled',
            'note'   => $request->input('reason', $borrowing->note),
        ]);

        Notification::create([
            'user_id' => $borrowing->member->user_id,
            'title'   => 'Peminjaman Ditolak',
            'message' => "Peminjaman #{$borrowing->id} ditolak.",
            'type'    => 'approval',
            'is_read' => false,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    /**
     * Cetak bukti peminjaman (PDF).
     */
    public function printReceipt(Borrowing $borrowing)
    {
        $borrowing->load(['member.user', 'librarian.user', 'borrowingItems.bookCopy.book']);

        $pdf = \PDF::loadView('transaction.borrowings.receipt', compact('borrowing'));

        return $pdf->stream("bukti-peminjaman-{$borrowing->id}.pdf");
    }

    /**
     * Ajukan perpanjangan masa pinjam.
     */
    public function requestExtension(Request $request, Borrowing $borrowing)
    {
        $request->validate(['requested_due_date' => 'required|date|after:' . $borrowing->due_date]);

        if ($borrowing->status !== 'borrowed') {
            return back()->withErrors(['error' => 'Hanya peminjaman aktif yang bisa diperpanjang.']);
        }

        $borrowing->update([
            'note' => trim(($borrowing->note ?? '') . " | Ajukan perpanjangan s/d {$request->requested_due_date}"),
        ]);

        return back()->with('success', 'Pengajuan perpanjangan terkirim, menunggu persetujuan petugas.');
    }

    /**
     * Setujui perpanjangan oleh petugas.
     */
    public function approveExtension(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate(['new_due_date' => 'required|date|after:' . $borrowing->due_date]);

        $borrowing->update(['due_date' => $validated['new_due_date']]);

        Notification::create([
            'user_id' => $borrowing->member->user_id,
            'title'   => 'Perpanjangan Disetujui',
            'message' => "Masa pinjam diperpanjang sampai {$validated['new_due_date']}.",
            'type'    => 'approval',
            'is_read' => false,
        ]);

        return back()->with('success', 'Perpanjangan disetujui.');
    }

    /**
     * Tolak pengajuan perpanjangan.
     */
    public function rejectExtension(Borrowing $borrowing)
    {
        Notification::create([
            'user_id' => $borrowing->member->user_id,
            'title'   => 'Perpanjangan Ditolak',
            'message' => "Pengajuan perpanjangan untuk peminjaman #{$borrowing->id} ditolak.",
            'type'    => 'approval',
            'is_read' => false,
        ]);

        return back()->with('success', 'Perpanjangan ditolak.');
    }
}
