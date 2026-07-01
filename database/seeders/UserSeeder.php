<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Role IDs: 1 = admin, 2 = petugas, 3 = anggota
        $users = [
            // Admin
            [
                'role_id'           => 1,
                'name'              => 'Administrator',
                'email'             => 'admin@bookverse.id',
                'password'          => Hash::make('password'),
                'phone'             => '081234567890',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Petugas 1
            [
                'role_id'           => 2,
                'name'              => 'Budi Santoso',
                'email'             => 'budi@bookverse.id',
                'password'          => Hash::make('password'),
                'phone'             => '082345678901',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Petugas 2
            [
                'role_id'           => 2,
                'name'              => 'Sari Dewi',
                'email'             => 'sari@bookverse.id',
                'password'          => Hash::make('password'),
                'phone'             => '083456789012',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Anggota 1
            [
                'role_id'           => 3,
                'name'              => 'Ahmad Fauzi',
                'email'             => 'ahmad@gmail.com',
                'password'          => Hash::make('password'),
                'phone'             => '085678901234',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Anggota 2
            [
                'role_id'           => 3,
                'name'              => 'Rina Marlina',
                'email'             => 'rina@gmail.com',
                'password'          => Hash::make('password'),
                'phone'             => '086789012345',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Anggota 3
            [
                'role_id'           => 3,
                'name'              => 'Doni Prasetyo',
                'email'             => 'doni@gmail.com',
                'password'          => Hash::make('password'),
                'phone'             => '087890123456',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Anggota 4
            [
                'role_id'           => 3,
                'name'              => 'Fitria Handayani',
                'email'             => 'fitria@gmail.com',
                'password'          => Hash::make('password'),
                'phone'             => '088901234567',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            // Anggota 5
            [
                'role_id'           => 3,
                'name'              => 'Hendra Kusuma',
                'email'             => 'hendra@gmail.com',
                'password'          => Hash::make('password'),
                'phone'             => '089012345678',
                'photo'             => null,
                'status'            => 'active',
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
