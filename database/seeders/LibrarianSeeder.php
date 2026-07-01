<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        // user_id 2 = Budi, 3 = Sari, 4 = Riko
        DB::table('librarians')->insert([
            [
                'user_id'       => 2,
                'employee_code' => 'PT-BUDI0001',
                'position'      => 'Kepala Perpustakaan',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'user_id'       => 3,
                'employee_code' => 'PT-SARI0001',
                'position'      => 'Staf Sirkulasi',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'user_id'       => 4,
                'employee_code' => 'PT-RIKO0001',
                'position'      => 'Staf Katalogisasi',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
