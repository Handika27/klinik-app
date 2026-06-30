<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'judul',
        'konten',
        'is_active',
        'tanggal_rilis'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_rilis' => 'datetime'
    ];
}
