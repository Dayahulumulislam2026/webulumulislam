<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'name',
        'graduation_levels',
        'display_units',
        'career_type',
        'position_or_program',
        'institution_or_company',
        'short_description',
        'photo_path',
        'status',
        'is_home_pinned',
    ];

    protected $casts = [
        'is_home_pinned' => 'boolean',
    ];

    public function getGraduationLevelsArrayAttribute(): array
    {
        return $this->graduation_levels ? explode(',', $this->graduation_levels) : [];
    }

    public function getDisplayUnitsArrayAttribute(): array
    {
        if (!$this->display_units) {
            return $this->graduation_levels_array;
        }
        return explode(',', $this->display_units);
    }

    public function hasGraduationLevel(string $level): bool
    {
        return in_array($level, $this->graduation_levels_array);
    }

    public function displaysInUnit(string $unit): bool
    {
        return in_array($unit, $this->display_units_array);
    }

    public function featured(): HasOne
    {
        return $this->hasOne(FeaturedAlumni::class, 'alumni_id');
    }
}
