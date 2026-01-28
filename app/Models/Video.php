<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $fillable = [
        'opds_id',
        'judul',
        'tanggal',
        'hits',
        'url',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'hits' => 'integer',
    ];

    // ✅ Auto-fill opds_id dari user yang login
    protected static function booted()
    {
        static::creating(function ($video) {
            // Auto-fill opds_id dari user yang login (jika user punya OPD)
            if (auth()->check() && auth()->user()->opds_id && !$video->opds_id) {
                $video->opds_id = auth()->user()->opds_id;
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
     * Get YouTube Video ID from URL
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (preg_match('/[?&]v=([^&]+)/', $this->url, $matches)) {
            return $matches[1];
        }
        if (preg_match('/youtu\.be\/([^?]+)/', $this->url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Get YouTube Embed URL
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $videoId = $this->youtube_id;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    /**
     * Get YouTube Thumbnail
     */
    public function getThumbnailAttribute(): string
    {
        $videoId = $this->youtube_id;
        return $videoId 
            ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
            : '/images/video-placeholder.png';
    }
}
