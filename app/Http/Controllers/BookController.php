<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\BookImage;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milon\Barcode\DNS1D;

class BookController extends Controller
{
    /**
     * Daftar buku: search, filter kategori/penulis, sorting, pagination.
     */
    public function index(Request $request)
    {
        $books = Book::query()
            ->with(['publisher', 'authors', 'categories'])
            ->withCount('bookCopies')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('isbn', 'like', "%{$request->search}%");
            }))
            ->when($request->filled('category_id'), fn ($q) => $q->whereHas('categories', fn ($q) =>
                $q->where('categories.id', $request->category_id)
            ))
            ->when($request->filled('author_id'), fn ($q) => $q->whereHas('authors', fn ($q) =>
                $q->where('authors.id', $request->author_id)
            ))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderBy($request->get('sort_by', 'title'), $request->get('sort_dir', 'asc'))
            ->paginate(15)
            ->withQueryString();

        return view('master.books.index', [
            'books'      => $books,
            'categories' => Category::all(),
            'authors'    => Author::all(),
        ]);
    }

    public function create()
    {
        return view('master.books.create', [
            'publishers' => Publisher::all(),
            'authors'    => Author::all(),
            'categories' => Category::all(),
            'tags'       => Tag::all(),
            'shelves'    => Shelf::all(),
        ]);
    }

    /**
     * Simpan buku baru + cover + multi copy sekaligus.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'publisher_id'      => 'required|exists:publishers,id',
            'isbn'              => 'required|string|unique:books,isbn|max:20',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'publication_year'  => 'nullable|digits:4',
            'language'          => 'nullable|string|max:50',
            'pages'             => 'nullable|integer|min:1',
            'edition'           => 'nullable|string|max:50',
            'stock'             => 'required|integer|min:1',
            'status'            => 'required|in:active,inactive',
            'cover'             => 'nullable|image|max:2048',
            'author_ids'        => 'required|array|min:1',
            'author_ids.*'      => 'exists:authors,id',
            'category_ids'      => 'required|array|min:1',
            'category_ids.*'    => 'exists:categories,id',
            'tag_ids'           => 'nullable|array',
            'tag_ids.*'         => 'exists:tags,id',
            'shelf_id'          => 'required|exists:shelves,id',
            'gallery.*'         => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $slug = Str::slug($validated['title']) . '-' . Str::random(5);
            $barcode = 'BK-' . strtoupper(Str::random(10));

            $coverPath = $request->hasFile('cover')
                ? $request->file('cover')->store('books/covers', 'public')
                : null;

            $book = Book::create([
                'publisher_id'     => $validated['publisher_id'],
                'isbn'             => $validated['isbn'],
                'title'            => $validated['title'],
                'slug'             => $slug,
                'description'      => $validated['description'] ?? null,
                'publication_year' => $validated['publication_year'] ?? null,
                'language'         => $validated['language'] ?? null,
                'pages'            => $validated['pages'] ?? null,
                'cover'            => $coverPath,
                'barcode'          => $barcode,
                'edition'          => $validated['edition'] ?? null,
                'stock'            => $validated['stock'],
                'available_stock'  => $validated['stock'],
                'status'           => $validated['status'],
            ]);

            $book->authors()->sync($validated['author_ids']);
            $book->categories()->sync($validated['category_ids']);
            $book->tags()->sync($validated['tag_ids'] ?? []);

            // Multi copy: buat salinan fisik buku sejumlah stock
            for ($i = 1; $i <= $validated['stock']; $i++) {
                BookCopy::create([
                    'book_id'   => $book->id,
                    'shelf_id'  => $validated['shelf_id'],
                    'copy_code' => $book->isbn . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'barcode'   => 'CP-' . strtoupper(Str::random(10)),
                    'condition' => 'good',
                    'status'    => 'available',
                ]);
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    BookImage::create([
                        'book_id' => $book->id,
                        'image'   => $image->store('books/gallery', 'public'),
                    ]);
                }
            }
        });

        return redirect()->route('master.books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        $book->load(['publisher', 'authors', 'categories', 'tags', 'bookImages', 'bookCopies.shelf']);

        return view('master.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $book->load(['authors', 'categories', 'tags']);

        return view('master.books.edit', [
            'book'       => $book,
            'publishers' => Publisher::all(),
            'authors'    => Author::all(),
            'categories' => Category::all(),
            'tags'       => Tag::all(),
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'publisher_id'      => 'required|exists:publishers,id',
            'isbn'              => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'publication_year'  => 'nullable|digits:4',
            'language'          => 'nullable|string|max:50',
            'pages'             => 'nullable|integer|min:1',
            'edition'           => 'nullable|string|max:50',
            'status'            => 'required|in:active,inactive',
            'cover'             => 'nullable|image|max:2048',
            'author_ids'        => 'required|array|min:1',
            'author_ids.*'      => 'exists:authors,id',
            'category_ids'      => 'required|array|min:1',
            'category_ids.*'    => 'exists:categories,id',
            'tag_ids'           => 'nullable|array',
            'tag_ids.*'         => 'exists:tags,id',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('books/covers', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']) . '-' . $book->id;

        $book->update($validated);
        $book->authors()->sync($validated['author_ids']);
        $book->categories()->sync($validated['category_ids']);
        $book->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('master.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->bookCopies()->where('status', 'borrowed')->exists()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus, masih ada salinan yang dipinjam.']);
        }

        $book->delete();

        return redirect()->route('master.books.index')->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Generate barcode image (SVG) untuk satu salinan buku.
     */
    public function generateBarcode(BookCopy $bookCopy)
    {
        $generator = new DNS1D();
        $barcodeSvg = $generator->getBarcodeSVG($bookCopy->barcode, 'C128');

        return response($barcodeSvg)->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Tambah salinan (copy) baru untuk buku yang sudah ada.
     */
    public function addCopy(Request $request, Book $book)
    {
        $validated = $request->validate([
            'shelf_id' => 'required|exists:shelves,id',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        DB::transaction(function () use ($book, $validated) {
            $currentCount = $book->bookCopies()->count();

            for ($i = 1; $i <= $validated['quantity']; $i++) {
                BookCopy::create([
                    'book_id'   => $book->id,
                    'shelf_id'  => $validated['shelf_id'],
                    'copy_code' => $book->isbn . '-' . str_pad($currentCount + $i, 3, '0', STR_PAD_LEFT),
                    'barcode'   => 'CP-' . strtoupper(Str::random(10)),
                    'condition' => 'good',
                    'status'    => 'available',
                ]);
            }

            $book->increment('stock', $validated['quantity']);
            $book->increment('available_stock', $validated['quantity']);
        });

        return back()->with('success', 'Salinan buku berhasil ditambahkan.');
    }
}
