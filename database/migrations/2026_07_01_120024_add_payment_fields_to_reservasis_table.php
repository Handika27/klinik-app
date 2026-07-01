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
        Schema::table('reservasis', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum', 'lunas'])->default('belum');
            $table->string('metode_pembayaran')->nullable();
            $table->integer('total_biaya')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'metode_pembayaran', 'total_biaya']);
        });
    }
};
