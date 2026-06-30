<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationQueue;
use App\Models\Book;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Daftar reservasi (untuk petugas/admin).
     */
    public function index(Request $request)
    {
        $reservations = Reservation::query()
            ->with(['member.user', 'book'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderBy('reservation_date')
            ->paginate(15)
            ->withQueryString();

        return view('transaction.reservations.index', compact('reservations'));
    }

    /**
     * Reservasi sebuah buku yang sedang habis stok tersedianya.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['book_id' => 'required|exists:books,id']);

        $book = Book::findOrFail($validated['book_id']);
        $member = Auth::user()->member;

        if (! $member) {
            return back()->withErrors(['error' => 'Hanya anggota yang bisa melakukan reservasi.']);
        }

        if ($book->available_stock > 0) {
            return back()->withErrors(['error' => 'Buku masih tersedia, silakan lakukan peminjaman langsung.']);
        }

        $exists = Reservation::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['waiting', 'ready'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Anda sudah memiliki reservasi aktif untuk buku ini.']);
        }

        DB::transaction(function () use ($member, $book) {
            $reservation = Reservation::create([
                'member_id'        => $member->id,
                'book_id'          => $book->id,
                'reservation_date' => now(),
                'expired_at'       => now()->addDays(config('library.reservation_expiry_days', 3)),
                'status'           => 'waiting',
            ]);

            $lastQueue = ReservationQueue::whereHas('reservation', fn ($q) =>
                $q->where('book_id', $book->id)->where('status', 'waiting')
            )->max('queue_number');

            ReservationQueue::create([
                'reservation_id' => $reservation->id,
                'queue_number'   => ($lastQueue ?? 0) + 1,
            ]);
        });

        return back()->with('success', 'Reservasi berhasil dibuat, Anda akan dinotifikasi saat buku tersedia.');
    }

    /**
     * Lihat antrian reservasi untuk satu buku.
     */
    public function queue(Book $book)
    {
        $queue = ReservationQueue::with('reservation.member.user')
            ->whereHas('reservation', fn ($q) => $q->where('book_id', $book->id)->where('status', 'waiting'))
            ->orderBy('queue_number')
            ->get();

        return view('transaction.reservations.queue', compact('book', 'queue'));
    }

    /**
     * Batalkan reservasi.
     */
    public function cancel(Reservation $reservation)
    {
        if (! in_array($reservation->status, ['waiting', 'ready'])) {
            return back()->withErrors(['error' => 'Reservasi tidak bisa dibatalkan.']);
        }

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reservasi dibatalkan.');
    }

    /**
     * Konversi reservasi yang sudah "ready" menjadi peminjaman (dipanggil petugas).
     */
    public function fulfill(Reservation $reservation)
    {
        if ($reservation->status !== 'ready') {
            return back()->withErrors(['error' => 'Reservasi belum siap untuk diambil.']);
        }

        $reservation->update(['status' => 'fulfilled']);

        return redirect()->route('transaction.borrowings.create', ['member_id' => $reservation->member_id, 'book_id' => $reservation->book_id])
            ->with('success', 'Silakan lanjutkan proses peminjaman untuk reservasi ini.');
    }

    /**
     * Tandai reservasi kedaluwarsa (dipanggil scheduler/cron).
     */
    public function expireOverdue()
    {
        $expired = Reservation::where('status', 'ready')
            ->where('expired_at', '<', now())
            ->get();

        foreach ($expired as $reservation) {
            $reservation->update(['status' => 'expired']);

            Notification::create([
                'user_id' => $reservation->member->user_id,
                'title'   => 'Reservasi Kedaluwarsa',
                'message' => 'Reservasi buku Anda telah kedaluwarsa karena tidak diambil tepat waktu.',
                'type'    => 'reservation',
                'is_read' => false,
            ]);
        }

        return response()->json(['expired_count' => $expired->count()]);
    }
}
