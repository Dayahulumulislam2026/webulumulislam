<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'short_description',
        'description',
        'vision',
        'mission',
        'phone',
        'whatsapp',
        'address',
        'logo_path',
        'banner_path',
    ];

    protected $casts = [
        'mission' => 'array',
    ];

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(InstitutionProgram::class)->orderBy('sort_order');
    }

    public function structurePositions(): HasMany
    {
        return $this->hasMany(StructurePosition::class)->orderBy('sort_order');
    }

    public function galleryAlbums(): HasMany
    {
        return $this->hasMany(GalleryAlbum::class)->orderBy('sort_order');
    }

    public function admissionSetting(): HasOne
    {
        return $this->hasOne(AdmissionSetting::class);
    }

    public function getMissionListAttribute(): array
    {
        if (is_array($this->mission)) {
            return $this->mission;
        }
        if (is_string($this->mission)) {
            return array_values(array_filter(array_map('trim', explode("\n", $this->mission))));
        }
        return [];
    }

    public function getMissionTextAttribute(): string
    {
        if (is_array($this->mission)) {
            return implode("\n", $this->mission);
        }
        return (string) ($this->mission ?? '');
    }

    public function getLogoUrlAttribute(): string
    {
        if (!empty($this->logo_path)) {
            if (str_starts_with($this->logo_path, 'http://') || str_starts_with($this->logo_path, 'https://')) {
                return $this->logo_path;
            }
            return asset(ltrim($this->logo_path, '/'));
        }
        return asset('logo.png');
    }

    public function getBannerUrlAttribute(): ?string
    {
        if (!empty($this->banner_path)) {
            if (str_starts_with($this->banner_path, 'http://') || str_starts_with($this->banner_path, 'https://')) {
                return $this->banner_path;
            }
            return asset(ltrim($this->banner_path, '/'));
        }
        return null;
    }
}
