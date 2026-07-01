<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShelfSeeder extends Seeder
{
    public function run(): void
    {
        $shelves = [
            // 1 - Sastra & Fiksi
            ['code' => 'A01', 'name' => 'Sastra Indonesia',    'floor' => '1', 'description' => 'Karya sastra penulis Indonesia: novel, puisi, cerpen'],
            ['code' => 'A02', 'name' => 'Sastra Asing',        'floor' => '1', 'description' => 'Karya sastra terjemahan dari luar negeri'],
            ['code' => 'A03', 'name' => 'Fiksi Umum',          'floor' => '1', 'description' => 'Novel fiksi populer dan genre campuran'],
            ['code' => 'A04', 'name' => 'Anak dan Remaja',     'floor' => '1', 'description' => 'Buku cerita, komik edukasi, dan buku remaja'],
            // 2 - Ilmu Pengetahuan & Teknologi
            ['code' => 'B01', 'name' => 'Ilmu Pengetahuan',    'floor' => '2', 'description' => 'Sains, biologi, fisika, kimia, dan penelitian'],
            ['code' => 'B02', 'name' => 'Teknologi & IT',      'floor' => '2', 'description' => 'Komputer, pemrograman, jaringan, dan AI'],
            ['code' => 'B03', 'name' => 'Sejarah & Geografi',  'floor' => '2', 'description' => 'Sejarah dunia, Indonesia, dan atlas geografi'],
            ['code' => 'B04', 'name' => 'Agama & Filsafat',    'floor' => '2', 'description' => 'Kitab, fiqih, akidah, filsafat, dan etika'],
            // 3 - Sosial & Referensi
            ['code' => 'C01', 'name' => 'Ekonomi & Bisnis',    'floor' => '3', 'description' => 'Manajemen, akuntansi, marketing, dan keuangan'],
            ['code' => 'C02', 'name' => 'Hukum',               'floor' => '3', 'description' => 'Perundang-undangan, tata hukum, dan kriminologi'],
            ['code' => 'C03', 'name' => 'Kesehatan & Medis',   'floor' => '3', 'description' => 'Kedokteran, keperawatan, gizi, dan kesehatan'],
            ['code' => 'C04', 'name' => 'Referensi',           'floor' => '3', 'description' => 'Kamus, ensiklopedi, atlas, dan buku indeks'],
        ];

        foreach ($shelves as $shelf) {
            DB::table('shelves')->insert(array_merge($shelf, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
