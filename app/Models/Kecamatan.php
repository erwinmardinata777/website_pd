<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan'
    ];

    public $incrementing = false;
    protected $primaryKey = 'kode_kecamatan';
    protected $keyType = 'string';

    // Relasi ke Desa
    public function desa()
    {
        return $this->hasMany(Desa::class, 'kode_kecamatan', 'kode_kecamatan');
    }

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kode_kecamatan', 'kode_kecamatan');
    }    
}
