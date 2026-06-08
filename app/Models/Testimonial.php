<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'student_name',
        'student_email',
        'student_title',
        'course_name',
        'rating',
        'quote',
        'avatar',
        'status',
        'is_featured',
        'is_active',
        'is_public_submission',
        'order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'order' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_public_submission' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query
            ->where('status', self::STATUS_APPROVED)
            ->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'بانتظار المراجعة',
            self::STATUS_APPROVED => 'مقبول',
            self::STATUS_REJECTED => 'مرفوض',
            default => $this->status,
        };
    }
}
