<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publishers = Publisher::query()
            ->when($request->filled('search'), fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->withCount('books')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('master.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('master.publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:150',
            'website' => 'nullable|url|max:255',
        ]);

        Publisher::create($validated);

        return redirect()->route('master.publishers.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function show(Publisher $publisher)
    {
        $publisher->load('books');

        return view('master.publishers.show', compact('publisher'));
    }

    public function edit(Publisher $publisher)
    {
        return view('master.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:150',
            'website' => 'nullable|url|max:255',
        ]);

        $publisher->update($validated);

        return redirect()->route('master.publishers.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    public function destroy(Publisher $publisher)
    {
        if ($publisher->books()->exists()) {
            return back()->withErrors(['error' => 'Penerbit masih terkait dengan buku, tidak bisa dihapus.']);
        }

        $publisher->delete();

        return redirect()->route('master.publishers.index')->with('success', 'Penerbit berhasil dihapus.');
    }
}
