<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    protected $table = 'resep_obats';

    protected $fillable = [
        'rekam_medis_id',
        'obat_id',
        'jumlah',
        'aturan_pakai',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    public function rekam()
    {
        return $this->belongsTo(RekamMedis::class, 'rekam_medis_id');
    }
}
