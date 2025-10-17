<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriFoto extends Model
{
    protected $fillable = [
        'nama_kategori',
        'slug',
        'tanggal',
        'hits',
    ];

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'kategori_fotos_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama_kategori);
        });

        static::updating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama_kategori);
        });
    }
}
