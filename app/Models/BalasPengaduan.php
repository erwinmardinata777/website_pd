<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalasPengaduan extends Model
{
    use HasTenant; // ✅ Gunakan trait

    protected $fillable = ['pengaduans_id', 'tanggapan', 'tanggal_balas'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduans_id');
    }
}
