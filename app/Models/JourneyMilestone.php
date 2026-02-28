<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JourneyMilestone extends Model
{
    protected $fillable = [
        'journey_category_id',
        'year',
        'title',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(JourneyCategory::class, 'journey_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
