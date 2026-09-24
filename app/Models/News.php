<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'scope',
        'excerpt',
        'content',
        'thumbnail_path',
        'gallery_images',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'gallery_images' => 'array',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->author?->name ?? 'Admin Ulumul Islam';
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (!empty($this->thumbnail_path)) {
            if (str_starts_with($this->thumbnail_path, 'http://') || str_starts_with($this->thumbnail_path, 'https://')) {
                return $this->thumbnail_path;
            }
            return asset(ltrim($this->thumbnail_path, '/'));
        }
        return null;
    }

    public function getCoverImageAttribute(): ?string
    {
        return $this->thumbnail_url ?: $this->thumbnail_path;
    }

    public function getFeaturedImageAttribute(): ?string
    {
        return $this->thumbnail_url ?: $this->thumbnail_path;
    }

    public function getInstitutionBadgeAttribute(): string
    {
        return match($this->scope) {
            'foundation' => 'Yayasan',
            'dayah' => 'Dayah Terpadu',
            'smp' => 'SMP Ulumul Islam',
            'sma' => 'SMA Ulumul Islam',
            'ikada' => 'IKADA UI',
            default => 'Warta Resmi',
        };
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        if (!is_array($this->gallery_images)) {
            return [];
        }

        return array_map(function ($img) {
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                return $img;
            }
            return asset(ltrim($img, '/'));
        }, $this->gallery_images);
    }
}
