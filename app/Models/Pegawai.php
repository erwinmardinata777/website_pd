<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'jenis_kelamin',
        'alamat',
        'status_kawin',
        'no_hp',
        'pendidikan_terakhir',
        'jabatan',
        'parent',
        'bidangs_id',
        'nip',
        'pangkat_golongan',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'foto',
    ];

    // Relasi ke bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidangs_id');
    }

    // Relasi ke parent (atasan)
    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'parent');
    }

    // Relasi ke bawahan
    public function bawahan()
    {
        return $this->hasMany(Pegawai::class, 'parent');
    }
}
