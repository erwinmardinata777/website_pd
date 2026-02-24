<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasTenant;

class FotoLowonganKerja extends Model
{
    use HasTenant; // Tambahkan trait

    protected $fillable = [
        'opds_id',
        'lowongan_kerjas_id',
        'foto',
    ];

    // ✅ Auto-fill opds_id dari lowongan atau user
    protected static function booted()
    {
        static::creating(function ($foto) {
            // Prioritas 1: Ambil dari lowongan kerja (jika ada)
            if ($foto->lowongan_kerjas_id && !$foto->opds_id) {
                $lowongan = LowonganKerja::find($foto->lowongan_kerjas_id);
                if ($lowongan && $lowongan->opds_id) {
                    $foto->opds_id = $lowongan->opds_id;
                }
            }

            // Prioritas 2: Ambil dari user yang login
            if (!$foto->opds_id && auth()->check() && auth()->user()->opds_id) {
                $foto->opds_id = auth()->user()->opds_id;
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
     * Relasi ke LowonganKerja
     */
    public function lowonganKerja(): BelongsTo
    {
        return $this->belongsTo(LowonganKerja::class, 'lowongan_kerjas_id');
    }
}
