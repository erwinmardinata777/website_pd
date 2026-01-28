<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foto extends Model
{
    protected $fillable = [
        'opds_id',
        'kategori_fotos_id',
        'judul',
        'gambar',
    ];

    // ✅ Auto-fill opds_id dari kategori atau user
    protected static function booted()
    {
        static::creating(function ($foto) {
            // Prioritas 1: Ambil dari kategori (jika ada)
            if ($foto->kategori_fotos_id && !$foto->opds_id) {
                $kategori = KategoriFoto::find($foto->kategori_fotos_id);
                if ($kategori && $kategori->opds_id) {
                    $foto->opds_id = $kategori->opds_id;
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
     * Relasi ke KategoriFoto
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriFoto::class, 'kategori_fotos_id');
    }
}
