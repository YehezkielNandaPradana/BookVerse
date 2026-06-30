<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Member;
use App\Models\Librarian;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Redirect ke dashboard sesuai role user yang login.
     */
    public function index()
    {
        $user = Auth::user();

        return match ($user->role?->name) {
            'admin'   => $this->admin(),
            'petugas' => $this->petugas(),
            default   => $this->member(),
        };
    }

    /**
     * Dashboard Admin: statistik global, grafik, aktivitas terbaru.
     */
    public function admin()
    {
        $data = [
            'total_buku'       => Book::count(),
            'total_anggota'    => Member::count(),
            'total_petugas'    => Librarian::count(),
            'buku_dipinjam'    => BookCopy::where('status', 'borrowed')->count(),
            'buku_tersedia'    => BookCopy::where('status', 'available')->count(),
            'buku_terlambat'   => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', now())
                ->count(),
            'grafik_peminjaman' => $this->grafikPeminjaman(),
            'aktivitas_terbaru' => ActivityLog::with('user')
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return view('dashboard.admin', $data);
    }

    /**
     * Dashboard Petugas: fokus operasional harian.
     */
    public function petugas()
    {
        $data = [
            'peminjaman_pending' => Borrowing::where('status', 'pending')->count(),
            'jatuh_tempo_hari_ini' => Borrowing::where('status', 'borrowed')
                ->whereDate('due_date', now()->toDateString())
                ->count(),
            'buku_terlambat' => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', now())
                ->with('member.user')
                ->limit(10)
                ->get(),
            'aktivitas_terbaru' => ActivityLog::where('user_id', Auth::id())
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return view('dashboard.petugas', $data);
    }

    /**
     * Dashboard Anggota: ringkasan peminjaman pribadi.
     */
    public function member()
    {
        $member = Auth::user()->member;

        $data = [
            'sedang_dipinjam' => $member?->borrowings()
                ->where('status', 'borrowed')
                ->with('borrowingItems.bookCopy.book')
                ->get(),
            'riwayat_peminjaman' => $member?->borrowings()
                ->latest()
                ->limit(5)
                ->get(),
            'total_denda_belum_lunas' => $member
                ? DB::table('fines')
                    ->join('returns', 'fines.return_id', '=', 'returns.id')
                    ->join('borrowings', 'returns.borrowing_id', '=', 'borrowings.id')
                    ->where('borrowings.member_id', $member->id)
                    ->where('fines.status', 'unpaid')
                    ->sum('fines.amount')
                : 0,
        ];

        return view('dashboard.member', $data);
    }

    /**
     * Endpoint AJAX: grafik peminjaman per bulan (untuk chart.js).
     */
    private function grafikPeminjaman()
    {
        return Borrowing::selectRaw('MONTH(borrow_date) as bulan, COUNT(*) as total')
            ->whereYear('borrow_date', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
    }
}
