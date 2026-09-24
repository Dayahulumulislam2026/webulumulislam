<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StructurePosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'category', // leader, vice, division
        'position_name',
        'sort_order',
        'is_pinned',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
    ];


    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(StructureMember::class, 'position_id');
    }
}
