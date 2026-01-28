<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visi extends Model
{
    protected $fillable = [
        'opds_id',
        'visi',
    ];

    // ✅ Auto-fill opds_id dari user yang login
    protected static function booted()
    {
        static::creating(function ($visi) {
            // Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$visi->opds_id) {
                $visi->opds_id = auth()->user()->opds_id;
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
