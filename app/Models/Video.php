<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    protected $fillable = [
        'title',
        'video_url',
        'thumbnail',
        'views_count',
        'description',
        'order',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'views_count' => 'integer',
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
     * Get the thumbnail URL: custom upload or YouTube auto thumbnail.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return route('video.image', ['filename' => basename($this->thumbnail)]);
        }
        $id = $this->getYoutubeVideoId();
        return $id
            ? 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg'
            : '';
    }

    /**
     * Extract YouTube video ID from url (youtube.com/watch?v= or youtu.be/).
     */
    public function getYoutubeVideoId(): ?string
    {
        if (!$this->video_url) {
            return null;
        }
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $this->video_url, $m)) {
            return $m[1];
        }
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $this->video_url, $m)) {
            return $m[1];
        }
        return null;
    }
}
