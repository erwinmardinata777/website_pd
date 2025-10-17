<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    protected $fillable = [
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
        });

        static::updating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama_layanan);
        });
    }
}
