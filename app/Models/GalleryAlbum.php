<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'title',
        'slug',
        'description',
        'cover_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(GalleryMedia::class, 'album_id')->orderBy('sort_order');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryMedia::class, 'album_id')->where('type', 'image')->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(GalleryMedia::class, 'album_id')->where('type', 'video')->orderBy('sort_order');
    }
}
