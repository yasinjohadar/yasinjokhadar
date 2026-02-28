<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'course_category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'image',
        'badge',
        'price',
        'old_price',
        'duration_hours',
        'lessons_count',
        'students_count',
        'level',
        'language',
        'is_active',
        'order',
        'meta_title',
        'meta_description',
        'highlights',
        'learn_items',
        'requirements',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_active' => 'boolean',
        'order' => 'integer',
        'duration_hours' => 'integer',
        'lessons_count' => 'integer',
        'students_count' => 'integer',
    ];

    /**
     * Get the category of the course.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    /**
     * Get the sections of the course ordered by their position.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class)->orderBy('order');
    }

    /**
     * Scope to get only active courses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });

        static::updating(function ($course) {
            if ($course->isDirty('title') && empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    /**
     * Convert stored text (one item per line) into an array.
     *
     * @param  string|null  $value
     * @return array
     */
    protected function explodeLines(?string $value): array
    {
        if (!$value) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', $value);

        return collect($lines)
            ->map(fn ($line) => trim($line))
            ->filter(fn ($line) => $line !== '')
            ->values()
            ->all();
    }

    public function getHighlightsItemsAttribute(): array
    {
        return $this->explodeLines($this->highlights);
    }

    public function getLearnItemsItemsAttribute(): array
    {
        return $this->explodeLines($this->learn_items);
    }

    public function getRequirementsItemsAttribute(): array
    {
        return $this->explodeLines($this->requirements);
    }
}
