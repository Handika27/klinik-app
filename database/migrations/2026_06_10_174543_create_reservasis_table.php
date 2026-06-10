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
    Schema::create('reservasis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('jadwal_id')->constrained('jadwal_dokters')->onDelete('cascade');
        $table->date('tanggal_kunjungan');
        $table->integer('nomor_antrean');
        $table->text('keluhan_awal')->nullable();
        $table->enum('status', ['pending', 'dikonfirmasi', 'selesai', 'batal'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
