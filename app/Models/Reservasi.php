<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasis';

    protected $fillable = [
        'pasien_id',
        'jadwal_id',
        'tanggal_kunjungan',
        'nomor_antrean',
        'keluhan_awal',
        'status',
    ];

    public function pasien()
    {
        return $this->belongsTo(\App\Models\User::class, 'pasien_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(\App\Models\JadwalDokter::class, 'jadwal_id');
    }
}
