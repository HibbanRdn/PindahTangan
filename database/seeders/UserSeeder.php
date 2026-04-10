<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama
        User::create([
            'name'              => 'Admin PindahTangan',
            'email'             => 'admin@pindahtangan.test',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        // Akun pembeli untuk testing
        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'budi@example.test',
            'password'          => Hash::make('password'),
            'role'              => 'user',
            'email_verified_at' => now(),
            // email_verified_at diisi agar akun ini bisa langsung checkout
            // tanpa perlu verifikasi email saat development
        ]);

        // Akun pembeli belum verifikasi (untuk testing flow verifikasi email)
        User::create([
            'name'              => 'Siti Unverified',
            'email'             => 'siti@example.test',
            'password'          => Hash::make('password'),
            'role'              => 'user',
            'email_verified_at' => null,
            // null: simulasi user yang belum verifikasi email
        ]);
    }
}