<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RekamMedisController;

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
    Route::get('/dokter/dashboard', [RekamMedisController::class, 'dashboard'])->name('dokter.dashboard');

    // Rute Pasien
    Route::get('/pasien/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    // Rute CRUD Jadwal Dokter dan Obat
    Route::resource('jadwal', JadwalDokterController::class);
    Route::post('jadwal/sync-users', [JadwalDokterController::class, 'syncUsers'])->name('jadwal.syncUsers');
    Route::resource('obat', ObatController::class);
    // Reservasi: pasien melihat jadwal & booking
    Route::get('pasien/jadwal', [ReservasiController::class, 'pasienJadwal'])->name('pasien.jadwal');
    Route::get('pasien/reservasi', [ReservasiController::class, 'pasienIndex'])->name('pasien.reservasi.index');
    Route::get('reservasi/create/{jadwal}', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

    // Admin reservasi management
    Route::get('admin/reservasi', [ReservasiController::class, 'adminIndex'])->name('admin.reservasi.index');
    Route::post('admin/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])->name('admin.reservasi.updateStatus');

    // Dokter: lihat pasien hari ini yang sudah dikonfirmasi + isi rekam medis
    Route::get('dokter/pasien-hari-ini', [RekamMedisController::class, 'index'])->name('dokter.rekam.index');
    Route::get('dokter/rekam/create/{reservasi}', [RekamMedisController::class, 'create'])->name('dokter.rekam.create');
    Route::post('dokter/rekam', [RekamMedisController::class, 'store'])->name('dokter.rekam.store');
    Route::post('dokter/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])->name('dokter.reservasi.updateStatus');
    Route::get('dokter/reservasi', [ReservasiController::class, 'dokterIndex'])->name('dokter.reservasi.index');

    // Pasien: riwayat rekam medis
    Route::get('pasien/riwayat', [RekamMedisController::class, 'riwayatPasien'])->name('pasien.riwayat');
    Route::get('pasien/riwayat/{id}', [RekamMedisController::class, 'showPasien'])->name('pasien.riwayat.show');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
