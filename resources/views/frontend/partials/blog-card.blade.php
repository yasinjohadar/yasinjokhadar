@php
    $delayClass = $delayClass ?? ('animate-delay-' . ($loop->iteration ?? 1));
    $fallbackImage = $fa . '/images/course-webdev.svg';
    $imageUrl = $post->featured_image
        ? route('blog.image', ['filename' => basename($post->featured_image)])
        : $fallbackImage;
    $showAuthor = $showAuthor ?? false;
    $excerptLimit = $excerptLimit ?? 80;
@endphp

<a href="{{ route('blog.show', $post->slug) }}" class="blog-card-link">
    <div class="glass-panel blog-card animate-on-scroll {{ $delayClass }}">
        <div class="blog-img-wrapper">
            <img
                src="{{ $imageUrl }}"
                alt="{{ $post->featured_image_alt ?? $post->title }}"
                width="1920"
                height="1080"
                loading="lazy"
                onerror="this.onerror=null;this.src='{{ $fallbackImage }}';this.closest('.blog-img-wrapper').classList.add('is-fallback');"
            >
            @if($post->category)
            <span class="blog-category-badge">{{ $post->category->name }}</span>
            @endif
        </div>
        <div class="blog-body">
            <div class="blog-meta">
                <span class="blog-meta-item"><i class="fas fa-calendar-alt"></i> {{ $post->published_at?->translatedFormat('d F Y') }}</span>
                @if($showAuthor && $post->reading_time)
                <span class="blog-meta-item"><i class="fas fa-clock"></i> {{ $post->reading_time }} دقيقة</span>
                @elseif(!$showAuthor)
                <span class="blog-meta-item"><i class="fas fa-tag"></i> {{ $post->category?->name ?? '—' }}</span>
                @endif
            </div>
            <h5>{{ $post->title }}</h5>
            <p>{{ Str::limit(strip_tags($post->excerpt ?? $post->content), $excerptLimit) }}</p>
            @if($showAuthor)
            <div class="blog-footer">
                <div class="blog-author">
                    <img src="{{ $fa }}/images/logo.svg" alt="{{ $post->author?->name ?? 'ياسين جوخدار' }}" width="30" height="30" loading="lazy">
                    <span>{{ $post->author?->name ?? 'ياسين جوخدار' }}</span>
                </div>
                <span class="read-more">المزيد <i class="fas fa-arrow-left"></i></span>
            </div>
            @else
            <span class="read-more">اقرأ المزيد <i class="fas fa-arrow-left"></i></span>
            @endif
        </div>
    </div>
</a>
