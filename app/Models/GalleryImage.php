<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'order',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the image URL for display (via route or asset).
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image || !Storage::disk('public')->exists($this->image)) {
            return '';
        }
        return route('gallery.image', ['filename' => basename($this->image)]);
    }
}
