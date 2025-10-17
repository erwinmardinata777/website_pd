<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'kategori_dokumens_id',
        'judul',
        'deskripsi',
        'type_file',
        'url',
        'file',
        'text',
        'tanggal',
        'hits',
        'download',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumens_id');
    }
}
