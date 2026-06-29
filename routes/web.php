<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ReservasiController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Kelompok Rute yang mewajibkan user untuk Login
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute Terminal Pusat (Redirector)
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } else {
            return redirect()->route('pasien.dashboard');
        }
    })->name('dashboard');

    // Rute Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Rute Dokter
    Route::get('/dokter/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    // Rute Pasien
    Route::get('/pasien/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    // Rute CRUD Jadwal Dokter (Hanya bisa diakses yang sudah login)
    Route::resource('jadwal', JadwalDokterController::class);
    // Rute CRUD Obat
    Route::resource('obat', ObatController::class);
    // Reservasi: pasien melihat jadwal & booking
    Route::get('pasien/jadwal', [ReservasiController::class, 'pasienJadwal'])->name('pasien.jadwal');
    Route::get('reservasi/create/{jadwal}', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

    // Admin reservasi management
    Route::get('admin/reservasi', [ReservasiController::class, 'adminIndex'])->name('admin.reservasi.index');
    Route::post('admin/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])->name('admin.reservasi.updateStatus');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
