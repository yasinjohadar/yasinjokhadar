<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'student_name',
        'student_title',
        'course_name',
        'rating',
        'quote',
        'avatar',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'order' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
