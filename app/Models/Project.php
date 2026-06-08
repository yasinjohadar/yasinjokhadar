<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'project_category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'image',
        'demo_url',
        'code_url',
        'tags',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ProjectVideo::class)->orderBy('order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class)->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getTagsArrayAttribute(): array
    {
        if (!$this->tags) {
            return [];
        }
        return collect(explode(',', $this->tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        try {
            return route('project.image', ['filename' => basename($this->image)]);
        } catch (\Throwable) {
            return asset('storage/' . ltrim($this->image, '/'));
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}
