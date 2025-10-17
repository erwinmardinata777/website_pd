<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agenda extends Model
{
    protected $fillable = [
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

    // 🔹 Generate slug otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agenda) {
            $agenda->slug = Str::slug($agenda->agenda);
        });

        static::updating(function ($agenda) {
            $agenda->slug = Str::slug($agenda->agenda);
        });
    }
}
