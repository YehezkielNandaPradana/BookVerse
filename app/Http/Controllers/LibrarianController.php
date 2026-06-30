<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LibrarianController extends Controller
{
    public function index(Request $request)
    {
        $librarians = Librarian::query()
            ->with('user')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('employee_code', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn ($q) =>
                      $q->where('name', 'like', "%{$request->search}%")
                  );
            }))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('master.librarians.index', compact('librarians'));
    }

    public function create()
    {
        return view('master.librarians.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:8',
            'photo'    => 'nullable|image|max:2048',
            'position' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('users/photos', 'public')
                : null;

            $user = User::create([
                'role_id'  => config('library.petugas_role_id', 2),
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'photo'    => $photoPath,
                'status'   => 'active',
            ]);

            Librarian::create([
                'user_id'       => $user->id,
                'employee_code' => 'PT-' . strtoupper(Str::random(8)),
                'position'      => $validated['position'],
            ]);
        });

        return redirect()->route('master.librarians.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function show(Librarian $librarian)
    {
        $librarian->load(['user', 'borrowings' => fn ($q) => $q->latest()->limit(10)]);

        return view('master.librarians.show', compact('librarian'));
    }

    public function edit(Librarian $librarian)
    {
        $librarian->load('user');

        return view('master.librarians.edit', compact('librarian'));
    }

    public function update(Request $request, Librarian $librarian)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email,' . $librarian->user_id,
            'phone'    => 'nullable|string|max:20',
            'photo'    => 'nullable|image|max:2048',
            'position' => 'required|string|max:100',
            'status'   => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($request, $librarian, $validated) {
            $userData = [
                'name'   => $validated['name'],
                'email'  => $validated['email'],
                'phone'  => $validated['phone'] ?? null,
                'status' => $validated['status'],
            ];

            if ($request->hasFile('photo')) {
                if ($librarian->user->photo) {
                    Storage::disk('public')->delete($librarian->user->photo);
                }
                $userData['photo'] = $request->file('photo')->store('users/photos', 'public');
            }

            $librarian->user->update($userData);
            $librarian->update(['position' => $validated['position']]);
        });

        return redirect()->route('master.librarians.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroy(Librarian $librarian)
    {
        if ($librarian->borrowings()->where('status', 'approved')->exists()) {
            return back()->withErrors(['error' => 'Petugas masih menangani transaksi aktif, tidak bisa dihapus.']);
        }

        DB::transaction(function () use ($librarian) {
            $librarian->delete();
            $librarian->user()->delete();
        });

        return redirect()->route('master.librarians.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
