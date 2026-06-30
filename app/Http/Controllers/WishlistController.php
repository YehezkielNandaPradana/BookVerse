<?php

namespace App\Http\Controllers;

use App\Models\MemberFavoriteBook;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Daftar wishlist/favorit milik anggota yang sedang login.
     */
    public function index()
    {
        $member = Auth::user()->member;

        $wishlists = MemberFavoriteBook::with('book.authors')
            ->where('member_id', $member->id)
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Tambahkan buku ke wishlist.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['book_id' => 'required|exists:books,id']);

        $member = Auth::user()->member;

        if (! $member) {
            return back()->withErrors(['error' => 'Hanya anggota yang bisa menambahkan wishlist.']);
        }

        $exists = MemberFavoriteBook::where('member_id', $member->id)
            ->where('book_id', $validated['book_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Buku sudah ada di wishlist Anda.']);
        }

        MemberFavoriteBook::create([
            'member_id' => $member->id,
            'book_id'   => $validated['book_id'],
        ]);

        return back()->with('success', 'Buku ditambahkan ke wishlist.');
    }

    /**
     * Hapus buku dari wishlist.
     */
    public function destroy(MemberFavoriteBook $wishlist)
    {
        if ($wishlist->member_id !== Auth::user()->member?->id) {
            abort(403);
        }

        $wishlist->delete();

        return back()->with('success', 'Buku dihapus dari wishlist.');
    }
}
