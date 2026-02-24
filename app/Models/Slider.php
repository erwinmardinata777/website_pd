<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasTenant; // ✅ Tambahkan

class Slider extends Model
{
    use HasTenant; // ✅ Gunakan trait
    
    protected $fillable = [
        'opds_id',
        'judul',
        'gambar',
        'link',
    ];

    // ✅ Auto-fill opds_id dari user yang login
    protected static function booted()
    {
        static::creating(function ($slider) {
            // Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$slider->opds_id) {
                $slider->opds_id = auth()->user()->opds_id;
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
