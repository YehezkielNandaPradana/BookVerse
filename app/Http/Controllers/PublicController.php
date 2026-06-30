<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Announcement;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Landing page: buku terbaru, kategori populer, pengumuman aktif.
     */
    public function home()
    {
        return view('public.home', [
            'latest_books'  => Book::with('authors')->where('status', 'active')->latest()->limit(8)->get(),
            'categories'    => Category::withCount('books')->orderByDesc('books_count')->limit(8)->get(),
            'announcements' => Announcement::where('published_at', '<=', now())
                ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>=', now()))
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }

    /**
     * Katalog buku publik: search, filter kategori, sorting, pagination.
     */
    public function books(Request $request)
    {
        $books = Book::with(['authors', 'categories'])
            ->where('status', 'active')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('isbn', 'like', "%{$request->search}%");
            }))
            ->when($request->filled('category_id'), fn ($q) => $q->whereHas('categories', fn ($q) =>
                $q->where('categories.id', $request->category_id)
            ))
            ->orderBy($request->get('sort_by', 'title'), $request->get('sort_dir', 'asc'))
            ->paginate(12)
            ->withQueryString();

        return view('public.books.index', [
            'books'      => $books,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Detail buku publik.
     */
    public function bookDetail(Book $book)
    {
        $book->load(['publisher', 'authors', 'categories', 'tags', 'bookImages']);

        return view('public.books.show', [
            'book'             => $book,
            'available_copies' => $book->bookCopies()->where('status', 'available')->count(),
        ]);
    }

    /**
     * Halaman profil perpustakaan.
     */
    public function profile()
    {
        return view('public.profile', ['setting' => Setting::first()]);
    }

    public function contact()
    {
        return view('public.contact', ['setting' => Setting::first()]);
    }

    /**
     * Kirim pesan kontak (dikirim via email ke pengelola).
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        $setting = Setting::first();

        if ($setting?->email) {
            \Mail::raw($validated['message'], function ($mail) use ($setting, $validated) {
                $mail->to($setting->email)
                    ->subject($validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            });
        }

        return back()->with('success', 'Pesan Anda berhasil terkirim.');
    }
}
