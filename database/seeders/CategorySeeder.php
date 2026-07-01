<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi',             'description' => 'Karya sastra imajinatif dan cerita rekaan'],
            ['name' => 'Non-Fiksi',         'description' => 'Buku berisi fakta, biografi, dan pengetahuan nyata'],
            ['name' => 'Ilmu Pengetahuan',  'description' => 'Sains, biologi, fisika, kimia, dan penelitian'],
            ['name' => 'Teknologi',         'description' => 'Komputer, pemrograman, jaringan, dan teknologi informasi'],
            ['name' => 'Sejarah',           'description' => 'Peristiwa, tokoh, dan peradaban masa lampau'],
            ['name' => 'Filsafat',          'description' => 'Pemikiran, etika, logika, dan metafisika'],
            ['name' => 'Agama',             'description' => 'Kitab suci, fiqih, akidah, dan kerohanian'],
            ['name' => 'Ekonomi',           'description' => 'Bisnis, keuangan, manajemen, dan ilmu ekonomi'],
            ['name' => 'Hukum',             'description' => 'Perundang-undangan, tata hukum, dan kriminologi'],
            ['name' => 'Kesehatan',         'description' => 'Kedokteran, gizi, farmasi, dan kesehatan masyarakat'],
            ['name' => 'Pendidikan',        'description' => 'Pedagogik, psikologi pendidikan, dan kurikulum'],
            ['name' => 'Sastra Indonesia',  'description' => 'Puisi, prosa, dan drama karya penulis Indonesia'],
            ['name' => 'Sastra Asing',      'description' => 'Karya sastra terjemahan dari luar negeri'],
            ['name' => 'Anak-anak',         'description' => 'Buku cerita dan edukasi untuk anak'],
            ['name' => 'Referensi',         'description' => 'Kamus, ensiklopedi, atlas, dan buku rujukan'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
