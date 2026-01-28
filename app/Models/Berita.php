<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'opds_id',
        'judul',
        'slug',
        'deskripsi',
        'isi',
        'penulis',
        'thumb',
        'status',
        'tanggal',
        'hits',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ✅ Generate slug otomatis saat membuat atau mengubah judul
    protected static function booted()
    {
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
            
            // ✅ Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$berita->opds_id) {
                $berita->opds_id = auth()->user()->opds_id;
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = Str::slug($berita->judul);
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
}
