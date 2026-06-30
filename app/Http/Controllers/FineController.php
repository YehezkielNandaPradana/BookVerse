<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\FinePayment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FineController extends Controller
{
    /**
     * Daftar denda: filter status, search anggota.
     */
    public function index(Request $request)
    {
        $fines = Fine::query()
            ->with(['returnRecord.borrowing.member.user'])
            ->when($request->filled('search'), fn ($q) => $q->whereHas('returnRecord.borrowing.member.user', fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            ))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('transaction.fines.index', compact('fines'));
    }

    public function show(Fine $fine)
    {
        $fine->load(['returnRecord.borrowing.member.user', 'finePayments']);

        return view('transaction.fines.show', compact('fine'));
    }

    /**
     * Riwayat pembayaran denda untuk satu anggota.
     */
    public function memberHistory(int $memberId)
    {
        $fines = Fine::with(['returnRecord.borrowing', 'finePayments'])
            ->whereHas('returnRecord.borrowing', fn ($q) => $q->where('member_id', $memberId))
            ->orderByDesc('created_at')
            ->get();

        return view('transaction.fines.member-history', compact('fines'));
    }

    /**
     * Form pembayaran denda.
     */
    public function createPayment(Fine $fine)
    {
        if ($fine->status === 'paid') {
            return back()->withErrors(['error' => 'Denda ini sudah lunas.']);
        }

        return view('transaction.fines.pay', compact('fine'));
    }

    /**
     * Simpan pembayaran denda (tunai/transfer) + bukti upload, update status lunas.
     */
    public function storePayment(Request $request, Fine $fine)
    {
        if ($fine->status === 'paid') {
            return back()->withErrors(['error' => 'Denda ini sudah lunas.']);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $fine->amount,
            'method' => 'required|in:cash,transfer,e-wallet',
            'proof'  => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $fine, $validated) {
            $proofPath = $request->hasFile('proof')
                ? $request->file('proof')->store('fines/proofs', 'public')
                : null;

            FinePayment::create([
                'fine_id'      => $fine->id,
                'payment_date' => now(),
                'amount'       => $validated['amount'],
                'method'       => $validated['method'],
                'proof'        => $proofPath,
            ]);

            $totalPaid = $fine->finePayments()->sum('amount');

            if ($totalPaid >= $fine->amount) {
                $fine->update(['status' => 'paid']);

                Notification::create([
                    'user_id' => $fine->returnRecord->borrowing->member->user_id,
                    'title'   => 'Denda Lunas',
                    'message' => 'Pembayaran denda Anda telah diterima dan dinyatakan lunas.',
                    'type'    => 'fine',
                    'is_read' => false,
                ]);
            }
        });

        return redirect()->route('transaction.fines.show', $fine)->with('success', 'Pembayaran denda berhasil dicatat.');
    }
}
