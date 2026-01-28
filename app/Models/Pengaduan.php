<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    protected $fillable = [
        'opds_id',
        'nama',
        'telp',
        'alamat',
        'kode_kecamatan',
        'kode_desa',
        'pengaduan',
        'isi_pengaduan',
        'bukti',
        'status',
        'tanggal_pengaduan',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'date',
        'status' => 'integer',
    ];

    /**
     * Relasi ke OPD
     */
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opds_id');
    }

    /**
     * Relasi ke Balasan
     */
    public function balasan(): HasMany
    {
        return $this->hasMany(BalasPengaduan::class, 'pengaduans_id');
    }

    /**
     * Relasi ke Kecamatan
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kode_kecamatan', 'kode_kecamatan');
    }

    /**
     * Relasi ke Desa
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'kode_desa', 'kode_desa');
    }
}
