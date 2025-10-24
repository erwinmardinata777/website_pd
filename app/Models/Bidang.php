<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $fillable = [
        'nama_bidang',
        'thumb',
        'deskripsi',
    ];

    // Relasi ke pegawai
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'bidangs_id');
    }
}
