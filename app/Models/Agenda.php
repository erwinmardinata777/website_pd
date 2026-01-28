<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Agenda extends Model
{
    protected $fillable = [
        'opds_id',
        'agenda',
        'slug',
        'deskripsi',
        'gambar',
        'tempat',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status' => 'boolean',
    ];

    // 🔹 Generate slug otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agenda) {
            $agenda->slug = Str::slug($agenda->agenda);
            
            // ✅ Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$agenda->opds_id) {
                $agenda->opds_id = auth()->user()->opds_id;
            }
        });

        static::updating(function ($agenda) {
            $agenda->slug = Str::slug($agenda->agenda);
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
