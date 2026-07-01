<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'admin',
                'description' => 'Administrator sistem dengan akses penuh ke seluruh fitur',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'petugas',
                'description' => 'Petugas perpustakaan yang mengelola peminjaman dan pengembalian',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'anggota',
                'description' => 'Anggota perpustakaan yang dapat meminjam buku',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
