@php
    $fallbackImage = $fa . '/images/course-webdev.svg';
    $imageUrl = !empty($course->image)
        ? route('course.image', ['filename' => basename($course->image)])
        : $fallbackImage;
    $delayClass = $delayClass ?? ('animate-delay-' . ($loop->iteration ?? 1));
    $wrapperTag = $wrapperTag ?? 'a';
@endphp

@if($wrapperTag === 'a')
<a href="{{ route('course.show', $course->slug) }}" class="course-card-link">
    <div class="glass-panel course-card animate-on-scroll {{ $delayClass }}">
@else
<div class="glass-panel course-card animate-on-scroll {{ $delayClass }}">
@endif
        <div class="course-img-wrapper">
            <img
                src="{{ $imageUrl }}"
                alt="{{ $course->title }}"
                width="1920"
                height="1080"
                loading="lazy"
                onerror="this.onerror=null;this.src='{{ $fallbackImage }}';this.closest('.course-img-wrapper').classList.add('is-fallback');"
            >
            <div class="course-img-overlay">
                <span class="course-view-btn"><i class="fas fa-play-circle"></i> عرض التفاصيل</span>
            </div>
            @if($course->category)
            <span class="course-category-tag">{{ $course->category->name }}</span>
            @endif
            @if($course->badge)
            <span class="course-badge">{{ $course->badge }}</span>
            @endif
        </div>
        <div class="course-body">
            <h5>{{ $course->title }}</h5>
            <p>{{ $course->short_description ?? Str::limit($course->description ?? '', 100) }}</p>
        </div>
        <div class="course-footer">
            <div class="course-meta">
                <span class="course-meta-item"><i class="fas fa-users"></i> {{ number_format($course->students_count) }} طالب</span>
                <span class="course-meta-item"><i class="fas fa-clock"></i> {{ $course->duration_hours ? $course->duration_hours . ' ساعة' : '-' }}</span>
            </div>
            <span class="price">${{ number_format($course->price, 2) }}</span>
        </div>
@if($wrapperTag === 'a')
    </div>
</a>
@else
</div>
@endif
