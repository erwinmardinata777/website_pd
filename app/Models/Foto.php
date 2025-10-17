<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = [
        'kategori_fotos_id',
        'judul',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriFoto::class, 'kategori_fotos_id');
    }
}
