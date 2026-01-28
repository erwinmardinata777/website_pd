<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $fillable = [
        'opds_id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'jenis_kelamin',
        'alamat',
        'status_kawin',
        'no_hp',
        'pendidikan_terakhir',
        'jabatan',
        'parent',
        'bidangs_id',
        'nip',
        'pangkat_golongan',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ✅ Auto-fill opds_id dari bidang atau user
    protected static function booted()
    {
        static::creating(function ($pegawai) {
            // Prioritas 1: Ambil dari bidang (jika ada)
            if ($pegawai->bidangs_id && !$pegawai->opds_id) {
                $bidang = Bidang::find($pegawai->bidangs_id);
                if ($bidang && $bidang->opds_id) {
                    $pegawai->opds_id = $bidang->opds_id;
                }
            }

            // Prioritas 2: Ambil dari user yang login
            if (!$pegawai->opds_id && auth()->check() && auth()->user()->opds_id) {
                $pegawai->opds_id = auth()->user()->opds_id;
            }
        });
    }

    /**
     * Relasi ke OPD
     */
    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'opds_id');
    }

    /**
     * Relasi ke Bidang
     */
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'bidangs_id');
    }

    /**
     * Relasi ke Parent (Atasan)
     */
    public function atasan(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'parent');
    }

    /**
     * Relasi ke Bawahan
     */
    public function bawahan(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'parent');
    }
}
