<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // user_id 5–14 adalah anggota (lihat UserSeeder)
        $members = [
            [
                'user_id'      => 5,
                'member_code'  => 'MB-2024001',
                'nis'          => '2024001',
                'gender'       => 'male',
                'birth_place'  => 'Jakarta',
                'birth_date'   => '2003-05-15',
                'address'      => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'join_date'    => now()->subMonths(12),
                'expired_date' => now()->addMonths(12),
                'status'       => 'active',
            ],
        ];

        foreach ($members as $member) {
            DB::table('members')->insert(array_merge($member, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
