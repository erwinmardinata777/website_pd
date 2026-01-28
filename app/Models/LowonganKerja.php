<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LowonganKerja extends Model
{
    protected $fillable = [
        'opds_id',
        'judul',
        'nama_perusahaan',
        'deskripsi',
        'alamat',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ✅ Auto-fill opds_id dari user yang login
    protected static function booted()
    {
        static::creating(function ($lowongan) {
            // Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$lowongan->opds_id) {
                $lowongan->opds_id = auth()->user()->opds_id;
            }
        });
    }

    /**
     * Relasi ke OPD
     */
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opds_id');
    }

    /**
     * Relasi ke FotoLowonganKerja
     */
    public function fotoLowongans(): HasMany
    {
        return $this->hasMany(FotoLowonganKerja::class, 'lowongan_kerjas_id');
    }
}
