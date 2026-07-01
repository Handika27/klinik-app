<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update existing 'tidak aktif' to 'cuti'
        \App\Models\JadwalDokter::where('status', 'tidak aktif')->update(['status' => 'cuti']);
        
        // Then modify the enum column
        \DB::statement("ALTER TABLE jadwal_dokters MODIFY COLUMN status ENUM('aktif', 'cuti') NOT NULL DEFAULT 'aktif'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, update existing 'cuti' back to 'tidak aktif'
        \App\Models\JadwalDokter::where('status', 'cuti')->update(['status' => 'tidak aktif']);
        
        // Then modify the enum column back
        \DB::statement("ALTER TABLE jadwal_dokters MODIFY COLUMN status ENUM('aktif', 'tidak aktif') NOT NULL DEFAULT 'aktif'");
    }
};
