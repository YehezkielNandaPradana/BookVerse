<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use App\Models\ReturnRecord;
use App\Models\Fine;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
    /**
     * Laporan data buku (filter kategori, status, rentang tahun terbit).
     */
    public function books(Request $request)
    {
        $books = Book::with(['publisher', 'authors', 'categories'])
            ->when($request->filled('category_id'), fn ($q) => $q->whereHas('categories', fn ($q) =>
                $q->where('categories.id', $request->category_id)
            ))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderBy('title')
            ->get();

        return view('reports.books', compact('books'));
    }

    /**
     * Laporan data anggota.
     */
    public function members(Request $request)
    {
        $members = Member::with('user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('join_from'), fn ($q) => $q->whereDate('join_date', '>=', $request->join_from))
            ->when($request->filled('join_to'), fn ($q) => $q->whereDate('join_date', '<=', $request->join_to))
            ->orderByDesc('join_date')
            ->get();

        return view('reports.members', compact('members'));
    }

    /**
     * Laporan peminjaman (rentang tanggal, status).
     */
    public function borrowings(Request $request)
    {
        $borrowings = Borrowing::with(['member.user', 'librarian.user', 'borrowingItems.bookCopy.book'])
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('borrow_date', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('borrow_date', '<=', $request->date_to))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('borrow_date')
            ->get();

        return view('reports.borrowings', compact('borrowings'));
    }

    /**
     * Laporan pengembalian (rentang tanggal).
     */
    public function returns(Request $request)
    {
        $returns = ReturnRecord::with(['borrowing.member.user', 'returnedBy'])
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('return_date', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('return_date', '<=', $request->date_to))
            ->orderByDesc('return_date')
            ->get();

        return view('reports.returns', compact('returns'));
    }

    /**
     * Laporan denda (status lunas/belum, rentang tanggal).
     */
    public function fines(Request $request)
    {
        $fines = Fine::with(['returnRecord.borrowing.member.user'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->orderByDesc('created_at')
            ->get();

        return view('reports.fines', compact('fines'));
    }

    /**
     * Export laporan ke PDF berdasarkan jenis laporan.
     */
    public function exportPdf(Request $request, string $type)
    {
        $data = $this->resolveReportData($type, $request);

        $pdf = Pdf::loadView("reports.pdf.{$type}", $data);

        return $pdf->download("laporan-{$type}-" . now()->format('Ymd') . ".pdf");
    }

    /**
     * Export laporan ke Excel berdasarkan jenis laporan.
     */
    public function exportExcel(Request $request, string $type)
    {
        $data = $this->resolveReportData($type, $request);

        return Excel::download(new ReportExport($type, $data), "laporan-{$type}-" . now()->format('Ymd') . ".xlsx");
    }

    private function resolveReportData(string $type, Request $request): array
    {
        return match ($type) {
            'books'      => ['books' => $this->books($request)->getData()['books']],
            'members'    => ['members' => $this->members($request)->getData()['members']],
            'borrowings' => ['borrowings' => $this->borrowings($request)->getData()['borrowings']],
            'returns'    => ['returns' => $this->returns($request)->getData()['returns']],
            'fines'      => ['fines' => $this->fines($request)->getData()['fines']],
            default      => abort(404),
        };
    }
}
