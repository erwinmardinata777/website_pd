<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profil extends Model
{
    protected $fillable = [
        'opds_id',
        'judul',
        'isi',
        'tanggal',
        'hits',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'hits' => 'integer',
    ];

    // ✅ Auto-fill opds_id dari user yang login
    protected static function booted()
    {
        static::creating(function ($profil) {
            // Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$profil->opds_id) {
                $profil->opds_id = auth()->user()->opds_id;
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
