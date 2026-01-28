<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $fillable = [
        'opds_id',
        'kategori_dokumens_id',
        'judul',
        'deskripsi',
        'type_file',
        'url',
        'file',
        'text',
        'tanggal',
        'hits',
        'download',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status' => 'boolean',
        'hits' => 'integer',
        'download' => 'integer',
    ];

    // ✅ Auto-fill opds_id dari user atau dari kategori
    protected static function booted()
    {
        static::creating(function ($dokumen) {
            // Prioritas 1: Ambil dari kategori (jika ada)
            if ($dokumen->kategori_dokumens_id && !$dokumen->opds_id) {
                $kategori = KategoriDokumen::find($dokumen->kategori_dokumens_id);
                if ($kategori && $kategori->opds_id) {
                    $dokumen->opds_id = $kategori->opds_id;
                }
            }

            // Prioritas 2: Ambil dari user yang login
            if (!$dokumen->opds_id && auth()->check() && auth()->user()->opds_id) {
                $dokumen->opds_id = auth()->user()->opds_id;
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
     * Relasi ke KategoriDokumen
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumens_id');
    }
}
