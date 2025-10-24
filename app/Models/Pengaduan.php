<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'nama', 'telp', 'alamat', 'kode_kecamatan', 'kode_desa',
        'pengaduan', 'isi_pengaduan', 'bukti', 'status', 'tanggal_pengaduan',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'date'
    ];
        
    public function balasan()
    {
        return $this->hasMany(BalasPengaduan::class, 'pengaduans_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kode_kecamatan', 'kode_kecamatan');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'kode_desa', 'kode_desa');
    }

}
