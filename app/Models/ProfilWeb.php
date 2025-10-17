<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilWeb extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'deskripsi_full',        
        'keyword',
        'url',
        'alamat',
        'email',
        'telp',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'googlemap',
        'bg',
        'logo',
    ];
}
