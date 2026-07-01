<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BorrowingSeeder extends Seeder
{
    /**
     * Membuat beberapa transaksi peminjaman dummy untuk kebutuhan demo:
     * - 1 transaksi masih aktif dipinjam (status: borrowed)
     * - 1 transaksi sudah dikembalikan (status: returned)
     * - 1 transaksi terlambat dikembalikan (status: borrowed, due_date lampau)
     * - 1 transaksi pending approval (status: pending)
     *
     * Asumsikan:
     *   member_id 1 = Ahmad, member_id 2 = Rina (dari MemberSeeder, ID auto-increment dari 1)
     *   librarian_id 1 = Budi (dari LibrarianSeeder)
     *   book_copy IDs: lihat BookSeeder — copy 1 = "Laskar Pelangi" salinan ke-1, dst.
     *   (karena BookSeeder dijalankan lebih dulu, copy ID dimulai dari 1)
     */
    public function run(): void
    {
        // ── 1. Peminjaman AKTIF: Ahmad pinjam "Laskar Pelangi" ──────────────────
        $borrowingId1 = DB::table('borrowings')->insertGetId([
            'member_id'    => 1,
            'librarian_id' => 1,
            'borrow_date'  => now()->subDays(3),
            'due_date'     => now()->addDays(4),
            'status'       => 'borrowed',
            'note'         => null,
            'created_at'   => now()->subDays(3),
            'updated_at'   => now()->subDays(3),
        ]);

        // Ambil copy pertama "Laskar Pelangi" (book_id=1, copy ke-1)
        $copy1 = DB::table('book_copies')->where('book_id', 1)->first();
        DB::table('borrowing_items')->insert([
            'borrowing_id' => $borrowingId1,
            'book_copy_id' => $copy1->id,
            'created_at'   => now()->subDays(3),
            'updated_at'   => now()->subDays(3),
        ]);
        DB::table('book_copies')->where('id', $copy1->id)->update(['status' => 'borrowed']);
        DB::table('books')->where('id', 1)->decrement('available_stock');

    }
}
