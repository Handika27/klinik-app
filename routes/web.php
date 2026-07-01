<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\AnnouncementController;

Route::get('/', function () {
    // Log out user if authenticated when visiting home page
    if (auth()->check()) {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        // Clear any cached data
        request()->session()->flush();
    }
    
    // Set anti-cache headers for the home page too
    header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
    
    $jadwals = \App\Models\JadwalDokter::with('user')->orderBy('jam_mulai')->get();
    $activeAnnouncements = \App\Models\Announcement::where('is_active', true)
                            ->orderBy('tanggal_rilis', 'desc')
                            ->get();
    return view('welcome', compact('jadwals', 'activeAnnouncements'));
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
    
    Route::post('/admin/clinic-status', function (Illuminate\Http\Request $request) {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        Cache::put('clinic_status', $request->status);
        Cache::put('shift1_open', $request->shift1_open);
        Cache::put('shift1_close', $request->shift1_close);
        Cache::put('shift2_open', $request->shift2_open);
        Cache::put('shift2_close', $request->shift2_close);
        return back()->with('success', 'Status dan Jam operasional (2 Shift) berhasil diperbarui!');
    })->name('admin.clinic.status.update');

    // Rute Dokter
    Route::get('/dokter/dashboard', [RekamMedisController::class, 'dashboard'])->name('dokter.dashboard');

    // Rute Pasien
            // Rute Pasien
Route::get('/pasien/dashboard', function() {
    // 1. Ambil data pengumuman aktif
    $activeAnnouncements = \App\Models\Announcement::where('is_active', true)
                            ->orderBy('tanggal_rilis', 'desc')
                            ->get();

    // 2. Kirim data ke view
    return view('pasien.dashboard', compact('activeAnnouncements'));
})->name('pasien.dashboard');

    // Rute CRUD Jadwal Dokter dan Obat
    Route::resource('jadwal', JadwalDokterController::class);
    Route::post('jadwal/sync-users', [JadwalDokterController::class, 'syncUsers'])->name('jadwal.syncUsers');
    Route::post('jadwal/{id}/toggle-status', [JadwalDokterController::class, 'toggleStatus'])->name('jadwal.toggleStatus');
    Route::resource('obat', ObatController::class);
    Route::resource('announcements', AnnouncementController::class);
    // Reservasi: pasien melihat jadwal & booking
    Route::get('pasien/jadwal', [ReservasiController::class, 'pasienJadwal'])->name('pasien.jadwal');
    Route::get('pasien/reservasi', [ReservasiController::class, 'pasienIndex'])->name('pasien.reservasi.index');
    Route::get('reservasi/create/{jadwal}', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

    // Admin reservasi management
    Route::get('admin/reservasi', [ReservasiController::class, 'adminIndex'])->name('admin.reservasi.index');
    Route::post('admin/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])->name('admin.reservasi.updateStatus');
    Route::post('admin/reservasi/{id}/bayar', [ReservasiController::class, 'markAsPaid'])->name('admin.reservasi.markAsPaid');

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
