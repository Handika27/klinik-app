<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;

    // Memberitahu Laravel kolom mana yang boleh diisi dari form
    protected $fillable = [
        'user_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];
}
