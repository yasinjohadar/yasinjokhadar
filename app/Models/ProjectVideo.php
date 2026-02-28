<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectVideo extends Model
{
    protected $fillable = [
        'project_id',
        'url',
        'title',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get embed URL for YouTube or Vimeo.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $url = $this->url;
        if (empty($url)) {
            return null;
        }
        // YouTube: watch?v=ID or youtu.be/ID
        if (preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]+)#', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        // Vimeo: vimeo.com/ID
        if (preg_match('#vimeo\.com/(?:video/)?(\d+)#', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }
        return null;
    }
}
