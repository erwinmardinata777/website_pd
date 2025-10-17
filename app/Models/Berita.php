<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
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
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }    
}
