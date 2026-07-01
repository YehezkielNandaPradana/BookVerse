<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Bestseller', 'Rekomendasi', 'Novel', 'Klasik', 'Inspiratif',
            'Motivasi', 'Petualangan', 'Romansa', 'Misteri', 'Thriller',
            'Biografi', 'Sejarah', 'Filsafat', 'Self-Help', 'Pengembangan Diri',
            'Teknologi', 'Sains', 'Budaya', 'Politik', 'Ekonomi',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name'       => $tag,
                'slug'       => Str::slug($tag),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
