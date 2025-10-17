<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoLowonganKerja extends Model
{
    protected $fillable = [
        'lowongan_kerjas_id',
        'foto',
    ];

    public function lowonganKerja()
    {
        return $this->belongsTo(LowonganKerja::class, 'lowongan_kerjas_id');
    }
}
