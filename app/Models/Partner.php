<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    public const TYPE_COMPANY = 'company';
    public const TYPE_CLIENT = 'client';
    public const TYPE_TRAINING = 'training';

    protected $fillable = [
        'name',
        'type',
        'logo',
        'description',
        'quote',
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

    public static function typeLabel(string $type): string
    {
        return match ($type) {
            self::TYPE_COMPANY => 'شركة',
            self::TYPE_CLIENT => 'عميل',
            self::TYPE_TRAINING => 'جهة تدريب',
            default => $type,
        };
    }

    public static function typesForSelect(): array
    {
        return [
            self::TYPE_COMPANY => 'شركة',
            self::TYPE_CLIENT => 'عميل',
            self::TYPE_TRAINING => 'جهة تدريب',
        ];
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            return route('partner.logo', ['filename' => basename($this->logo)]);
        }
        return asset('frontend/assets/images/logo.png');
    }
}
