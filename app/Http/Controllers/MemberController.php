<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::query()
            ->with('user')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('member_code', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn ($q) =>
                      $q->where('name', 'like', "%{$request->search}%")
                  );
            }))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('master.members.index', compact('members'));
    }

    public function create()
    {
        return view('master.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:150',
            'email'        => 'required|email|unique:users,email',
            'phone'        => 'nullable|string|max:20',
            'password'     => 'required|min:8',
            'photo'        => 'nullable|image|max:2048',
            'nis'          => 'nullable|string|max:30',
            'gender'       => 'required|in:L,P',
            'birth_place'  => 'nullable|string|max:100',
            'birth_date'   => 'nullable|date',
            'address'      => 'nullable|string',
            'expired_date' => 'required|date|after:today',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('users/photos', 'public')
                : null;

            $user = User::create([
                'role_id'  => config('library.member_role_id', 3),
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'] ?? null,
                'password' => Hash::make($validated['password']),
                'photo'    => $photoPath,
                'status'   => 'active',
            ]);

            Member::create([
                'user_id'      => $user->id,
                'member_code'  => 'MB-' . strtoupper(Str::random(8)),
                'nis'          => $validated['nis'] ?? null,
                'gender'       => $validated['gender'],
                'birth_place'  => $validated['birth_place'] ?? null,
                'birth_date'   => $validated['birth_date'] ?? null,
                'address'      => $validated['address'] ?? null,
                'join_date'    => now(),
                'expired_date' => $validated['expired_date'],
                'status'       => 'active',
            ]);
        });

        return redirect()->route('master.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $member->load(['user', 'borrowings', 'favoriteBooks']);

        return view('master.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $member->load('user');

        return view('master.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:150',
            'email'        => 'required|email|unique:users,email,' . $member->user_id,
            'phone'        => 'nullable|string|max:20',
            'photo'        => 'nullable|image|max:2048',
            'nis'          => 'nullable|string|max:30',
            'gender'       => 'required|in:L,P',
            'birth_place'  => 'nullable|string|max:100',
            'birth_date'   => 'nullable|date',
            'address'      => 'nullable|string',
            'expired_date' => 'required|date',
            'status'       => 'required|in:active,inactive,suspended',
        ]);

        DB::transaction(function () use ($request, $member, $validated) {
            $userData = [
                'name'  => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ];

            if ($request->hasFile('photo')) {
                if ($member->user->photo) {
                    Storage::disk('public')->delete($member->user->photo);
                }
                $userData['photo'] = $request->file('photo')->store('users/photos', 'public');
            }

            $member->user->update($userData);

            $member->update([
                'nis'          => $validated['nis'] ?? null,
                'gender'       => $validated['gender'],
                'birth_place'  => $validated['birth_place'] ?? null,
                'birth_date'   => $validated['birth_date'] ?? null,
                'address'      => $validated['address'] ?? null,
                'expired_date' => $validated['expired_date'],
                'status'       => $validated['status'],
            ]);
        });

        return redirect()->route('master.members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->borrowings()->where('status', 'borrowed')->exists()) {
            return back()->withErrors(['error' => 'Anggota masih memiliki peminjaman aktif, tidak bisa dihapus.']);
        }

        DB::transaction(function () use ($member) {
            $member->delete();
            $member->user()->delete();
        });

        return redirect()->route('master.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
