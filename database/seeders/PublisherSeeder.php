<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            [
                'name'    => 'Gramedia Pustaka Utama',
                'address' => 'Jl. Palmerah Barat No. 29-37, Jakarta Pusat',
                'phone'   => '(021) 5300330',
                'email'   => 'info@gramedia.com',
                'website' => 'https://www.gramedia.com',
            ],
            [
                'name'    => 'Mizan Pustaka',
                'address' => 'Jl. Cinambo No. 135, Ujungberung, Bandung',
                'phone'   => '(022) 7810995',
                'email'   => 'info@mizan.com',
                'website' => 'https://www.mizan.com',
            ],
            [
                'name'    => 'Bentang Pustaka',
                'address' => 'Jl. Pandega Padma No. 19, Yogyakarta',
                'phone'   => '(0274) 517373',
                'email'   => 'info@bentangpustaka.com',
                'website' => 'https://www.bentangpustaka.com',
            ],
            [
                'name'    => 'Republika Penerbit',
                'address' => 'Jl. Warung Buncit Raya No. 37, Jakarta Selatan',
                'phone'   => '(021) 7882481',
                'email'   => 'info@republika.co.id',
                'website' => 'https://www.republika.co.id',
            ],
            [
                'name'    => 'Erlangga',
                'address' => 'Jl. H. Baping Raya No. 100, Jakarta Timur',
                'phone'   => '(021) 4616880',
                'email'   => 'info@erlangga.co.id',
                'website' => 'https://www.erlangga.co.id',
            ],
            [
                'name'    => 'Bumi Aksara',
                'address' => 'Jl. Sawo Raya No. 18, Jakarta Timur',
                'phone'   => '(021) 8620462',
                'email'   => 'info@bumiaksara.co.id',
                'website' => 'https://www.bumiaksara.co.id',
            ],
            [
                'name'    => 'Kompas Media Nusantara',
                'address' => 'Jl. Palmerah Selatan No. 26-28, Jakarta Pusat',
                'phone'   => '(021) 5347710',
                'email'   => 'info@kompas.com',
                'website' => 'https://www.kompas.com',
            ],
            [
                'name'    => 'Noura Books',
                'address' => 'Jl. Kebayoran Lama No. 56, Jakarta Selatan',
                'phone'   => '(021) 7254659',
                'email'   => 'info@noura.mizan.com',
                'website' => 'https://www.noura.mizan.com',
            ],
        ];

        foreach ($publishers as $publisher) {
            DB::table('publishers')->insert(array_merge($publisher, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
