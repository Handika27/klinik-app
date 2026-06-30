<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Announcement;
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

        // Membuat contoh pengumuman
        Announcement::create([
            'judul' => 'Pengumuman: Perubahan Jam Operasional',
            'konten' => 'Dengan hormat, kami informasikan bahwa mulai tanggal 1 Juli 2026, jam operasional klinik berubah menjadi Senin-Sabtu 08:00-18:00 WIB. Terima kasih atas perhatiannya.',
            'is_active' => true,
            'tanggal_rilis' => now(),
        ]);

        Announcement::create([
            'judul' => 'Pengumuman: Libur Hari Raya',
            'konten' => 'Klinik akan tutup pada tanggal 25-26 Juni 2026 dalam rangka perayaan hari raya. Kami akan buka kembali pada tanggal 27 Juni 2026 pukul 08:00 WIB.',
            'is_active' => true,
            'tanggal_rilis' => now()->subDays(2),
        ]);
    }
}