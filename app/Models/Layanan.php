<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Traits\HasTenant;

class Layanan extends Model
{
    use HasTenant; // Tambahkan trait

    protected $fillable = [
        'opds_id',
        'nama_layanan',
        'slug',
        'deskripsi_singkat',
        'deskripsi_full',
        'thumb',
        'icon',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama_layanan);
            
            // ✅ Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$layanan->opds_id) {
                $layanan->opds_id = auth()->user()->opds_id;
            }
        });

        static::updating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama_layanan);
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
