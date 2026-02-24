<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\HasTenant;

class KategoriFoto extends Model
{
    use HasTenant; // Tambahkan trait

    protected $fillable = [
        'opds_id',
        'nama_kategori',
        'slug',
        'tanggal',
        'hits',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'hits' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama_kategori);
            
            // ✅ Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$kategori->opds_id) {
                $kategori->opds_id = auth()->user()->opds_id;
            }
        });

        static::updating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama_kategori);
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
     * Relasi ke Fotos
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(Foto::class, 'kategori_fotos_id');
    }
}
