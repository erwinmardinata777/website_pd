<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
    protected $fillable = ['judul'];

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'kategori_dokumens_id');
    }
}
