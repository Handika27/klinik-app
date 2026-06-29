# Product Requirements Document (PRD) - Klinik Medika

## 1. Project Overview

Klinik Medika adalah aplikasi web berbasis Laravel untuk manajemen reservasi, rekam medis, dan operasional klinik.
Tech Stack: Laravel 12, Tailwind CSS, Blade Components, MySQL.

## 2. User Roles & Access

Terdapat 3 role pengguna utama:

- **Admin (Asisten):** Mengelola master data (Jadwal Dokter, Obat) dan memvalidasi reservasi.
- **Dokter:** Melihat jadwal praktik, memberikan hasil diagnosis (Rekam Medis), dan meresepkan obat.
- **Pasien:** Melihat jadwal dokter yang tersedia dan melakukan booking/reservasi.

## 3. Current State (Selesai)

- Autentikasi dasar (Login/Register) menggunakan Laravel Breeze.
- Slicing UI Login & Welcome Page modern (Tailwind).
- Dashboard Admin & Sidebar Layout.
- **CRUD Jadwal Dokter** (Sudah lengkap dengan `try-catch` dan flash messages UI).
- Migrasi dan Model untuk `Reservasi`, `RekamMedis`, `Obat`, dan `ResepObat` sudah dibuat.

## 4. Pending Features (To-Do List)

Agen AI harus mengerjakan fitur-fitur ini secara bertahap:

1. **Fitur Manajemen Obat (Admin):** CRUD tabel `obats`.
2. **Fitur Reservasi (Pasien & Admin):** - Pasien dapat melihat jadwal dokter dan membuat `reservasi`.
    - Admin dapat melihat daftar reservasi dan mengubah statusnya (Misal: Menunggu, Disetujui, Selesai).
3. **Fitur Rekam Medis & Resep (Dokter):**
    - Dokter dapat melihat pasien yang berstatus "Disetujui" pada hari itu.
    - Dokter dapat mengisi `rekam_medis` (diagnosis) dan `resep_obat`.

## 5. Coding Standards & UI/UX Guidelines

- **Wajib menggunakan `try-catch`** pada setiap proses Create, Update, Delete di Controller.
- **Wajib mengembalikan flash session** (`success` atau `error`) menggunakan `->with()`.
- Untuk proses Edit gunakan `@method('PUT')` dan untuk Hapus gunakan `@method('DELETE')`.
- Tampilan (View) harus menggunakan **Tailwind CSS**.
- Gunakan `<x-app-layout>` untuk halaman yang memerlukan login, pastikan konten masuk ke dalam slot utama (sebelah kanan sidebar).
- Tombol aksi (Edit/Hapus) di tabel harus rapi (gunakan metode DELETE dengan form untuk fitur hapus beserta konfirmasi).
