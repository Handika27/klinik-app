<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Membuat akun Dokter
        User::create([
            'name' => 'Dr. Andi Hermawan',
            'email' => 'dokter@klinik.com',
            'password' => Hash::make('password123'),
            'role' => 'dokter',
        ]);

        // Membuat akun Pasien
        User::create([
            'name' => 'Pasien Umum',
            'email' => 'pasien@klinik.com',
            'password' => Hash::make('password123'),
            'role' => 'pasien',
        ]);
    }
}