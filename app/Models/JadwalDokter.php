<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Membuat jembatan relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}