<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Opd extends Model
{
    protected $fillable = [
        'nama_opd',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($opd) {
            $opd->slug = Str::slug($opd->nama_opd);
        });

        static::updating(function ($opd) {
            if ($opd->isDirty('nama_opd')) {
                $opd->slug = Str::slug($opd->nama_opd);
            }
        });
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            1 => 'OPD',
            2 => 'Kecamatan',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Relasi ke Users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'opds_id');
    }

    /**
     * Relasi ke Agendas
     */
    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class, 'opds_id');
    }

    /**
     * Relasi ke Beritas
     */
    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class, 'opds_id');
    }

    /**
     * Relasi ke Bidangs
     */
    public function bidangs(): HasMany
    {
        return $this->hasMany(Bidang::class, 'opds_id');
    }

    /**
     * Relasi ke KategoriDokumens
     */
    public function kategoriDokumens(): HasMany
    {
        return $this->hasMany(KategoriDokumen::class, 'opds_id');
    }

    /**
     * Relasi ke Dokumens
     */
    public function dokumens(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'opds_id');
    }

    /**
     * Relasi ke KategoriFotos
     */
    public function kategoriFotos(): HasMany
    {
        return $this->hasMany(KategoriFoto::class, 'opds_id');
    }

    /**
     * Relasi ke Fotos
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(Foto::class, 'opds_id');
    }

    /**
     * Relasi ke Layanans
     */
    public function layanans(): HasMany
    {
        return $this->hasMany(Layanan::class, 'opds_id');
    }

    /**
     * Relasi ke LinkTerkaits
     */
    public function linkTerkaits(): HasMany
    {
        return $this->hasMany(LinkTerkait::class, 'opds_id');
    }

    /**
     * Relasi ke LowonganKerjas
     */
    public function lowonganKerjas(): HasMany
    {
        return $this->hasMany(LowonganKerja::class, 'opds_id');
    }

    /**
     * Relasi ke FotoLowonganKerjas
     */
    public function fotoLowonganKerjas(): HasMany
    {
        return $this->hasMany(FotoLowonganKerja::class, 'opds_id');
    }

    /**
     * Relasi ke Misis
     */
    public function misis(): HasMany
    {
        return $this->hasMany(Misi::class, 'opds_id');
    }

    /**
     * Relasi ke Pegawais
     */
    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'opds_id');
    }

    /**
     * Relasi ke Pengaduans
     */
    public function pengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'opds_id');
    }

    /**
     * Relasi ke Profils
     */
    public function profils(): HasMany
    {
        return $this->hasMany(Profil::class, 'opds_id');
    }

    /**
     * Get single profil (biasanya 1 OPD = 1 Profil)
     */
    public function profil(): HasOne
    {
        return $this->hasOne(Profil::class, 'opds_id');
    }

    /**
     * Relasi ke ProfilWebs (multiple - jarang dipakai)
     */
    public function profilWebs(): HasMany
    {
        return $this->hasMany(ProfilWeb::class, 'opds_id');
    }

    /**
     * Get single profil web (biasanya 1 OPD = 1 ProfilWeb)
     */
    public function profilWeb(): HasOne
    {
        return $this->hasOne(ProfilWeb::class, 'opds_id');
    }

    /**
     * Relasi ke Sliders
     */
    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class, 'opds_id');
    }

    /**
     * Relasi ke TugasFungsis (multiple - jarang dipakai)
     */
    public function tugasFungsis(): HasMany
    {
        return $this->hasMany(TugasFungsi::class, 'opds_id');
    }

    /**
     * Get single tugas fungsi (biasanya 1 OPD = 1 TugasFungsi)
     */
    public function tugasFungsi(): HasOne
    {
        return $this->hasOne(TugasFungsi::class, 'opds_id');
    }

    /**
     * Relasi ke Videos
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'opds_id');
    }

    /**
     * Relasi ke Visis (multiple - jarang dipakai)
     */
    public function visis(): HasMany
    {
        return $this->hasMany(Visi::class, 'opds_id');
    }

    /**
     * Get single visi (biasanya 1 OPD = 1 Visi)
     */
    public function visi(): HasOne
    {
        return $this->hasOne(Visi::class, 'opds_id');
    }

}
