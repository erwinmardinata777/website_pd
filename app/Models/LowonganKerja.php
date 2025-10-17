<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LowonganKerja extends Model
{
    protected $fillable = [
        'judul',
        'nama_perusahaan',
        'deskripsi',
        'alamat',
        'tanggal',
    ];

    public function fotoLowongans()
    {
        return $this->hasMany(FotoLowonganKerja::class, 'lowongan_kerjas_id');
    }
}
