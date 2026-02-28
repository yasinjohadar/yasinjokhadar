<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLesson extends Model
{
    protected $fillable = [
        'course_section_id',
        'title',
        'slug',
        'summary',
        'content',
        'duration_minutes',
        'order',
        'is_preview',
        'is_active',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'order' => 'integer',
        'is_preview' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}

