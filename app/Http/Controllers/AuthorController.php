<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::query()
            ->when($request->filled('search'), fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->withCount('books')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('master.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('master.authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'biography'  => 'nullable|string',
            'country'    => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'photo'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        Author::create($validated);

        return redirect()->route('master.authors.index')->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function show(Author $author)
    {
        $author->load('books');

        return view('master.authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('master.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:150',
            'biography'  => 'nullable|string',
            'country'    => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'photo'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo) {
                Storage::disk('public')->delete($author->photo);
            }
            $validated['photo'] = $request->file('photo')->store('authors', 'public');
        }

        $author->update($validated);

        return redirect()->route('master.authors.index')->with('success', 'Penulis berhasil diperbarui.');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->exists()) {
            return back()->withErrors(['error' => 'Penulis masih terkait dengan buku, tidak bisa dihapus.']);
        }

        if ($author->photo) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();

        return redirect()->route('master.authors.index')->with('success', 'Penulis berhasil dihapus.');
    }
}
