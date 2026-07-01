<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            // Indonesia
            [
                'name'       => 'Andrea Hirata',
                'biography'  => 'Penulis novel Laskar Pelangi yang menjadi salah satu novel terlaris di Indonesia. Lahir di Belitung, ia meraih beasiswa ke Universitas Paris dan Sorbonne.',
                'country'    => 'Indonesia',
                'birth_date' => '1967-10-24',
            ],
            [
                'name'       => 'Pramoedya Ananta Toer',
                'biography'  => 'Salah satu sastrawan besar Indonesia, dikenal melalui Tetralogi Pulau Buru. Karyanya diterjemahkan ke lebih dari 40 bahasa dan sempat diusulkan sebagai penerima Nobel Sastra.',
                'country'    => 'Indonesia',
                'birth_date' => '1925-02-06',
            ],
            [
                'name'       => 'Dee Lestari',
                'biography'  => 'Penulis seri Supernova yang memadukan fiksi ilmiah dengan spiritualitas. Juga dikenal sebagai penyanyi dengan nama panggung Dee.',
                'country'    => 'Indonesia',
                'birth_date' => '1976-01-20',
            ],
            [
                'name'       => 'Tere Liye',
                'biography'  => 'Penulis produktif dengan ratusan novel. Karyanya dikenal dengan latar alam Indonesia yang kuat dan nilai moral yang mendalam.',
                'country'    => 'Indonesia',
                'birth_date' => '1979-05-21',
            ],
            [
                'name'       => 'Habiburrahman El Shirazy',
                'biography'  => 'Novelis berlatar Islam Indonesia, terkenal melalui Ayat-Ayat Cinta. Sering disebut "Kang Abik" dan merupakan seorang hafidz Quran.',
                'country'    => 'Indonesia',
                'birth_date' => '1976-09-30',
            ],
            [
                'name'       => 'Raditya Dika',
                'biography'  => 'Penulis, komedian, dan sutradara Indonesia yang terkenal lewat buku-buku humor semi-autobiografi. Pelopor blog humor di Indonesia.',
                'country'    => 'Indonesia',
                'birth_date' => '1984-12-28',
            ],
            [
                'name'       => 'Leila S. Chudori',
                'biography'  => 'Jurnalis dan novelis Indonesia, penulis novel Pulang yang berlatar kehidupan eksil politik Indonesia di Paris.',
                'country'    => 'Indonesia',
                'birth_date' => '1962-12-12',
            ],
            [
                'name'       => 'Ahmad Fuadi',
                'biography'  => 'Penulis Trilogi Negeri 5 Menara, wartawan, dan pendiri Komunitas Menara. Alumni Pesantren Gontor yang melanjutkan studi ke Amerika Serikat.',
                'country'    => 'Indonesia',
                'birth_date' => '1972-12-30',
            ],
            // Asing
            [
                'name'       => 'J.K. Rowling',
                'biography'  => 'Penulis asal Inggris yang menciptakan serial Harry Potter, salah satu seri buku terlaris sepanjang masa dengan lebih dari 500 juta eksemplar terjual.',
                'country'    => 'Inggris',
                'birth_date' => '1965-07-31',
            ],
            [
                'name'       => 'Paulo Coelho',
                'biography'  => 'Penulis Brasil terkenal melalui The Alchemist (Sang Alkemis), yang diterjemahkan ke lebih dari 80 bahasa dan terjual 150 juta eksemplar.',
                'country'    => 'Brasil',
                'birth_date' => '1947-08-24',
            ],
            [
                'name'       => 'Yuval Noah Harari',
                'biography'  => 'Sejarawan dan profesor dari Hebrew University of Jerusalem. Penulis trilogi Sapiens, Homo Deus, dan 21 Lessons for the 21st Century.',
                'country'    => 'Israel',
                'birth_date' => '1976-02-24',
            ],
            [
                'name'       => 'Dale Carnegie',
                'biography'  => 'Penulis dan pengembang kursus kepribadian serta komunikasi asal Amerika Serikat. Karyanya How to Win Friends and Influence People terbit 1936 dan masih relevan hingga kini.',
                'country'    => 'Amerika Serikat',
                'birth_date' => '1888-11-24',
            ],
            [
                'name'       => 'Stephen Covey',
                'biography'  => 'Penulis dan konsultan manajemen asal Amerika Serikat, terkenal melalui The 7 Habits of Highly Effective People yang terjual lebih dari 40 juta eksemplar.',
                'country'    => 'Amerika Serikat',
                'birth_date' => '1932-10-24',
            ],
            [
                'name'       => 'Haruki Murakami',
                'biography'  => 'Novelis Jepang dengan gaya surealis yang khas. Karyanya seperti Norwegian Wood dan Kafka on the Shore diterjemahkan ke lebih dari 50 bahasa.',
                'country'    => 'Jepang',
                'birth_date' => '1949-01-12',
            ],
            [
                'name'       => 'Khaled Hosseini',
                'biography'  => 'Novelis dan dokter asal Afghanistan-Amerika, terkenal melalui The Kite Runner (Pengejar Layang-layang) yang menjadi bestseller internasional.',
                'country'    => 'Afghanistan',
                'birth_date' => '1965-03-04',
            ],
        ];

        foreach ($authors as $author) {
            DB::table('authors')->insert(array_merge($author, [
                'photo'      => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
