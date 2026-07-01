<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan seeder SANGAT penting:
     * parent harus diisi sebelum child yang punya foreign key ke parent tersebut.
     *
     *  roles → users → librarians & members
     *  categories → tags → publishers → authors → shelves
     *  books → book_copies → pivot (book_author, book_category, book_tag)
     *  settings, announcements
     *  borrowings (membutuhkan members, librarians, book_copies sudah ada)
     */
    public function run(): void
    {
        $this->call([
            // ── Sistem & Akses ───────────────────────────────────────────
            RoleSeeder::class,
            UserSeeder::class,
            LibrarianSeeder::class,
            MemberSeeder::class,

            // ── Master Data ──────────────────────────────────────────────
            CategorySeeder::class,
            TagSeeder::class,
            PublisherSeeder::class,
            AuthorSeeder::class,
            ShelfSeeder::class,

            // ── Buku (includes copies + pivot) ───────────────────────────
            BookSeeder::class,

            // // ── Konfigurasi Sistem ───────────────────────────────────────
            // SettingSeeder::class,
            // AnnouncementSeeder::class,

            // ── Transaksi Demo ───────────────────────────────────────────
            BorrowingSeeder::class,
        ]);
    }
}
