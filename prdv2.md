# Product Requirements Document (PRD) - Klinik Medika

## 1. Project Overview

Aplikasi web manajemen reservasi dan rekam medis klinik untuk mendigitalisasi proses manual sesuai analisis PIECES dan SRS.

- **Tech Stack:** Laravel 12, Tailwind CSS, MySQL, Blade Components.

## 2. User Roles & Access

- **Admin (Asisten):** Manajemen stok obat, validasi reservasi, laporan kunjungan.
- **Dokter:** Rekam medis digital, input diagnosis, resep obat, manajemen antrean.
- **Pasien:** Reservasi online, lihat jadwal dokter, terima notifikasi status, lihat riwayat pemeriksaan.

## 3. Kebutuhan Fungsional (Feature Requirements)

| Modul              | Deskripsi Fitur                                                             | Role          |
| :----------------- | :-------------------------------------------------------------------------- | :------------ |
| **Reservasi**      | Pasien booking jadwal; Admin memvalidasi status (Menunggu/Disetujui).       | Pasien, Admin |
| **Rekam Medis**    | Dokter mengisi diagnosis, keluhan, dan tindakan pada pasien yang Disetujui. | Dokter        |
| **Manajemen Obat** | Admin input stok (nama, jenis, jumlah, harga); Dokter meresepkan.           | Admin, Dokter |
| **Notifikasi**     | Notifikasi status: Menunggu, Disetujui, Periksa, Selesai.                   | Semua         |
| **Dashboard**      | Admin (statistik), Dokter (antrean), Pasien (status reservasi).             | Semua         |

## 4. Coding Standards (Mandatory)

1. **Error Handling:** Wajib `try-catch` di setiap aksi `Controller` dan notifikasi `flash` (`->with()`).
2. **RESTful Routing:** Gunakan `PUT` untuk update dan `DELETE` untuk hapus.
3. **Database:** Wajib menggunakan Eloquent ORM dengan relasi yang didefinisikan di Model.
4. **UI/UX:** Gunakan Tailwind CSS dengan layout `<x-app-layout>`. Sidebar navigasi wajib dinamis sesuai `role` user.
5. **Security:** Proteksi semua rute dengan middleware `auth` dan pengecekan hak akses `role` di `web.php` atau `Controller`.

## 5. Sinkronisasi (SRS & PIECES Check)

- **PIECES Efficiency:** Sistem harus mengurangi waktu tunggu pasien melalui notifikasi real-time.
- **SRS Functional:** Semua fitur di tabel di atas adalah kebutuhan fungsional (FR) wajib untuk kelulusan projek.
