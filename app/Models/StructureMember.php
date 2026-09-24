<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StructureMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'name',
        'member_role', // leader, vice, head, member
        'title',
        'sub_role', // Penjelasan bagian yang dipegang
        'period',
        'photo_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(StructurePosition::class, 'position_id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!empty($this->photo_path)) {
            if (str_starts_with($this->photo_path, 'http://') || str_starts_with($this->photo_path, 'https://')) {
                return $this->photo_path;
            }
            return asset(ltrim($this->photo_path, '/'));
        }
        return null;
    }
}

