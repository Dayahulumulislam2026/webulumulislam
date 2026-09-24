<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedAlumni extends Model
{
    use HasFactory;

    protected $table = 'featured_alumni';

    protected $fillable = [
        'alumni_id',
        'placement',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }
}
