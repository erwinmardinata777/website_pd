<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $fillable = [
        'kode_kecamatan',
        'kode_desa',
        'nama_desa'
    ];

    public $incrementing = false;
    protected $primaryKey = 'kode_desa';
    protected $keyType = 'string';

    // Relasi ke Kecamatan
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kode_kecamatan', 'kode_kecamatan');
    }

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kode_desa', 'kode_desa');
    }
}
