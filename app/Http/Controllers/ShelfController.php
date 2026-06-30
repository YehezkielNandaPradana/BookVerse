<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function index(Request $request)
    {
        $shelves = Shelf::query()
            ->when($request->filled('search'), fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%")
            )
            ->withCount('bookCopies')
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('master.shelves.index', compact('shelves'));
    }

    public function create()
    {
        return view('master.shelves.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:shelves,code',
            'name'        => 'required|string|max:100',
            'floor'       => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        Shelf::create($validated);

        return redirect()->route('master.shelves.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function show(Shelf $shelf)
    {
        $shelf->load('bookCopies.book');

        return view('master.shelves.show', compact('shelf'));
    }

    public function edit(Shelf $shelf)
    {
        return view('master.shelves.edit', compact('shelf'));
    }

    public function update(Request $request, Shelf $shelf)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:shelves,code,' . $shelf->id,
            'name'        => 'required|string|max:100',
            'floor'       => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $shelf->update($validated);

        return redirect()->route('master.shelves.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Shelf $shelf)
    {
        if ($shelf->bookCopies()->exists()) {
            return back()->withErrors(['error' => 'Rak masih digunakan oleh salinan buku, tidak bisa dihapus.']);
        }

        $shelf->delete();

        return redirect()->route('master.shelves.index')->with('success', 'Rak berhasil dihapus.');
    }
}
