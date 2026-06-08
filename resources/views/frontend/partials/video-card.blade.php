@php
    $delayClass = $delayClass ?? ('animate-delay-' . ((($loop->iteration ?? 1) - 1) % 3 + 1));
    $fallbackThumb = $fa . '/images/course-webdev.svg';
    $thumbUrl = $video->thumbnail_url ?: $fallbackThumb;
@endphp

<a href="{{ $video->video_url }}" target="_blank" rel="noopener noreferrer" class="video-card-link">
    <div class="glass-panel video-card animate-on-scroll {{ $delayClass }}">
        <div class="video-wrapper">
            <img
                src="{{ $thumbUrl }}"
                alt="{{ $video->title }}"
                width="1920"
                height="1080"
                loading="lazy"
                onerror="this.onerror=null;this.src='{{ $fallbackThumb }}';this.closest('.video-wrapper').classList.add('is-fallback');"
            >
            <div class="video-overlay">
                <span class="video-watch-label"><i class="fas fa-play-circle"></i> شاهد الآن</span>
            </div>
            <span class="video-platform-badge" aria-hidden="true">
                <i class="fab fa-youtube"></i>
            </span>
        </div>
        <div class="video-body">
            <h6>{{ $video->title }}</h6>
            <div class="video-meta">
                <span class="video-meta-item"><i class="fas fa-eye"></i> {{ number_format($video->views_count) }} مشاهدة</span>
                <span class="video-meta-item video-meta-cta"><i class="fas fa-external-link-alt"></i> يوتيوب</span>
            </div>
        </div>
    </div>
</a>
