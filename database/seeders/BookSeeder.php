<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Daftar buku dummy beserta mapping ke publisher, author, category, tag, dan shelf.
     * Relasi menggunakan ID yang sudah diinsert sebelumnya oleh seeder lain.
     *
     * publisher_ids : 1=Gramedia 2=Mizan 3=Bentang 4=Republika 5=Erlangga 6=Bumi Aksara
     * author_ids    : 1=Andrea 2=Pramoedya 3=Dee 4=Tere 5=Habib 6=Raditya 7=Rowling 8=Coelho 9=Harari 10=Carnegie
     * category_ids  : 1=Fiksi 2=Non-Fiksi 3=Ilmu 4=Teknologi 5=Sejarah 6=Filsafat 7=Agama 8=Ekonomi 9=Hukum 10=Kesehatan 11=Pendidikan 12=Sastra Indo 13=Sastra Asing 14=Anak 15=Referensi
     * tag_ids       : 1=Bestseller 2=Rekomendasi 3=Novel 4=Klasik 5=Inspiratif 6=Motivasi ...
     * shelf_ids     : 1=A01 2=A02 3=A03 4=A04 5=B01 6=B02 7=B03 8=B04 9=C01 10=C02 11=C03 12=C04
     */
    private array $books = [
        [
            'publisher_id'     => 1,
            'isbn'             => '9789799731678',
            'title'            => 'Laskar Pelangi',
            'description'      => 'Novel karya Andrea Hirata yang menceritakan perjuangan anak-anak Belitung dalam mengejar mimpi di tengah keterbatasan. Telah diadaptasi menjadi film dengan penonton jutaan orang.',
            'publication_year' => 2005,
            'language'         => 'Indonesia',
            'pages'            => 534,
            'edition'          => 'Ke-1',
            'stock'            => 3,
            'status'           => 'available',
            'author_ids'       => [1],
            'category_ids'     => [1, 12],
            'tag_ids'          => [1, 3, 5],
            'shelf_id'         => 1,
        ],
        [
            'publisher_id'     => 3,
            'isbn'             => '9789799700872',
            'title'            => 'Bumi Manusia',
            'description'      => 'Novel pertama dari Tetralogi Pulau Buru karya Pramoedya Ananta Toer. Mengisahkan kehidupan Minke, seorang pemuda Indonesia di era kolonial Belanda.',
            'publication_year' => 1980,
            'language'         => 'Indonesia',
            'pages'            => 535,
            'edition'          => 'Ke-1',
            'stock'            => 2,
            'status'           => 'available',
            'author_ids'       => [2],
            'category_ids'     => [1, 5, 12],
            'tag_ids'          => [3, 4, 5],
            'shelf_id'         => 1,
        ],
        [
            'publisher_id'     => 1,
            'isbn'             => '9789797470203',
            'title'            => 'Supernova: Ksatria, Puteri, dan Bintang Jatuh',
            'description'      => 'Novel sains-fiksi pertama dari seri Supernova karya Dee Lestari, memadukan sains kuantum dengan cerita romansa yang menawan.',
            'publication_year' => 2001,
            'language'         => 'Indonesia',
            'pages'            => 328,
            'edition'          => 'Ke-1',
            'stock'            => 2,
            'status'           => 'available',
            'author_ids'       => [3],
            'category_ids'     => [1, 12],
            'tag_ids'          => [1, 3],
            'shelf_id'         => 1,
        ],
        [
            'publisher_id'     => 3,
            'isbn'             => '9789799221919',
            'title'            => 'Hujan',
            'description'      => 'Novel karya Tere Liye yang berlatar masa depan dan menceritakan perjalanan emosional dua insan yang saling mencintai.',
            'publication_year' => 2016,
            'language'         => 'Indonesia',
            'pages'            => 320,
            'edition'          => 'Ke-1',
            'stock'            => 3,
            'status'           => 'available',
            'author_ids'       => [4],
            'category_ids'     => [1, 12],
            'tag_ids'          => [2, 3, 8],
            'shelf_id'         => 1,
        ],
        [
            'publisher_id'     => 4,
            'isbn'             => '9789791617003',
            'title'            => 'Ayat-Ayat Cinta',
            'description'      => 'Novel religi karya Habiburrahman El Shirazy yang menceritakan kehidupan seorang mahasiswa Indonesia di Mesir.',
            'publication_year' => 2004,
            'language'         => 'Indonesia',
            'pages'            => 419,
            'edition'          => 'Ke-1',
            'stock'            => 3,
            'status'           => 'available',
            'author_ids'       => [5],
            'category_ids'     => [1, 7, 12],
            'tag_ids'          => [1, 3, 5],
            'shelf_id'         => 1,
        ],
        [
            'publisher_id'     => 1,
            'isbn'             => '9789792275261',
            'title'            => 'Kambing Jantan',
            'description'      => 'Buku diary Raditya Dika semasa kuliah di Adelaide yang lucu dan menghibur.',
            'publication_year' => 2005,
            'language'         => 'Indonesia',
            'pages'            => 249,
            'edition'          => 'Ke-1',
            'stock'            => 2,
            'status'           => 'available',
            'author_ids'       => [6],
            'category_ids'     => [2, 12],
            'tag_ids'          => [2, 3],
            'shelf_id'         => 1,
        ],
        [
            'publisher_id'     => 1,
            'isbn'             => '9789792276596',
            'title'            => 'Harry Potter dan Batu Bertuah',
            'description'      => 'Novel pertama seri Harry Potter karya J.K. Rowling yang mengisahkan seorang anak penyihir yang memasuki dunia sihir untuk pertama kalinya.',
            'publication_year' => 1997,
            'language'         => 'Indonesia',
            'pages'            => 392,
            'edition'          => 'Ke-1',
            'stock'            => 4,
            'status'           => 'available',
            'author_ids'       => [7],
            'category_ids'     => [1, 13, 14],
            'tag_ids'          => [1, 3, 4],
            'shelf_id'         => 2,
        ],
        [
            'publisher_id'     => 2,
            'isbn'             => '9789794334652',
            'title'            => 'Sang Alkemis',
            'description'      => 'Novel karya Paulo Coelho yang mengisahkan perjalanan seorang gembala muda dalam mencari harta karun dan menemukan jati diri.',
            'publication_year' => 1988,
            'language'         => 'Indonesia',
            'pages'            => 219,
            'edition'          => 'Ke-1',
            'stock'            => 3,
            'status'           => 'available',
            'author_ids'       => [8],
            'category_ids'     => [1, 6, 13],
            'tag_ids'          => [1, 4, 5, 6],
            'shelf_id'         => 2,
        ],
        [
            'publisher_id'     => 1,
            'isbn'             => '9789792297614',
            'title'            => 'Sapiens: Riwayat Singkat Umat Manusia',
            'description'      => 'Buku non-fiksi karya Yuval Noah Harari yang membahas sejarah evolusi dan perkembangan peradaban manusia secara komprehensif.',
            'publication_year' => 2011,
            'language'         => 'Indonesia',
            'pages'            => 514,
            'edition'          => 'Ke-1',
            'stock'            => 2,
            'status'           => 'available',
            'author_ids'       => [9],
            'category_ids'     => [2, 5],
            'tag_ids'          => [1, 2, 12],
            'shelf_id'         => 7,
        ],
        [
            'publisher_id'     => 5,
            'isbn'             => '9789790090651',
            'title'            => 'Bagaimana Mencari Kawan dan Mempengaruhi Orang Lain',
            'description'      => 'Buku pengembangan diri klasik karya Dale Carnegie tentang cara membangun hubungan sosial yang baik dan mempengaruhi orang secara positif.',
            'publication_year' => 1936,
            'language'         => 'Indonesia',
            'pages'            => 296,
            'edition'          => 'Revisi',
            'stock'            => 2,
            'status'           => 'available',
            'author_ids'       => [10],
            'category_ids'     => [2, 8],
            'tag_ids'          => [1, 4, 6],
            'shelf_id'         => 9,
        ],
        [
            'publisher_id'     => 6,
            'isbn'             => '9789796869312',
            'title'            => 'Pengantar Ilmu Komputer',
            'description'      => 'Buku referensi ilmu komputer untuk mahasiswa, membahas konsep dasar hardware, software, jaringan, dan pemrograman.',
            'publication_year' => 2020,
            'language'         => 'Indonesia',
            'pages'            => 480,
            'edition'          => 'Ke-3',
            'stock'            => 3,
            'status'           => 'available',
            'author_ids'       => [],
            'category_ids'     => [4],
            'tag_ids'          => [16],
            'shelf_id'         => 6,
        ],
        [
            'publisher_id'     => 5,
            'isbn'             => '9789790918962',
            'title'            => 'Akuntansi Keuangan Menengah',
            'description'      => 'Buku teks akuntansi keuangan untuk mahasiswa tingkat menengah, membahas laporan keuangan, jurnal penyesuaian, dan analisis laporan.',
            'publication_year' => 2021,
            'language'         => 'Indonesia',
            'pages'            => 612,
            'edition'          => 'Ke-5',
            'stock'            => 4,
            'status'           => 'available',
            'author_ids'       => [],
            'category_ids'     => [8],
            'tag_ids'          => [20],
            'shelf_id'         => 9,
        ],
    ];

    public function run(): void
    {
        foreach ($this->books as $index => $data) {
            $bookId = $this->insertBook($data);
            $this->insertBookCopies($bookId, $data['stock'], $data['shelf_id'], $data['isbn']);
            $this->insertPivot($bookId, $data);
        }
    }

    private function insertBook(array $data): int
    {
        $isbn = $data['isbn'];
        $title = $data['title'];

        return DB::table('books')->insertGetId([
            'publisher_id'     => $data['publisher_id'],
            'isbn'             => $isbn,
            'title'            => $title,
            'slug'             => Str::slug($title) . '-' . Str::random(5),
            'description'      => $data['description'],
            'publication_year' => $data['publication_year'],
            'language'         => $data['language'],
            'pages'            => $data['pages'],
            'cover'            => null,
            'barcode'          => 'BK-' . strtoupper(Str::random(10)),
            'edition'          => $data['edition'],
            'stock'            => $data['stock'],
            'available_stock'  => $data['stock'],
            'status'           => $data['status'],
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }

    private function insertBookCopies(int $bookId, int $stock, int $shelfId, string $isbn): void
    {
        for ($i = 1; $i <= $stock; $i++) {
            DB::table('book_copies')->insert([
                'book_id'    => $bookId,
                'shelf_id'   => $shelfId,
                'copy_code'  => $isbn . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'barcode'    => 'CP-' . strtoupper(Str::random(10)),
                'condition'  => 'good',
                'status'     => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function insertPivot(int $bookId, array $data): void
    {
        foreach ($data['author_ids'] as $authorId) {
            DB::table('book_author')->insert([
                'book_id'   => $bookId,
                'author_id' => $authorId,
            ]);
        }

        foreach ($data['category_ids'] as $categoryId) {
            DB::table('book_category')->insert([
                'book_id'     => $bookId,
                'category_id' => $categoryId,
            ]);
        }

        foreach ($data['tag_ids'] as $tagId) {
            DB::table('book_tag')->insert([
                'book_id' => $bookId,
                'tag_id'  => $tagId,
            ]);
        }
    }
}
