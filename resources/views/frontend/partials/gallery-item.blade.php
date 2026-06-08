@php
    $delayClass = $delayClass ?? ('animate-delay-' . ((($loop->iteration ?? 1) - 1) % 4 + 1));
    $featuredSpan = $featuredSpan ?? false;
    $isFeatured = $featuredSpan && ($item->is_featured ?? false);
@endphp

<article
    class="gallery-card gallery-item{{ $isFeatured ? ' gallery-card--featured' : '' }} animate-on-scroll {{ $delayClass }}"
    tabindex="0"
    role="button"
    aria-label="عرض {{ $item->title }}"
>
    <div class="gallery-card-inner">
        <div class="gallery-card-media">
            <img
                src="{{ $item->image_url }}"
                alt="{{ $item->title }}"
                width="1920"
                height="1080"
                loading="lazy"
            >
            <span class="gallery-card-shine" aria-hidden="true"></span>
        </div>
        <div class="gallery-card-overlay">
            <span class="gallery-card-zoom" aria-hidden="true">
                <i class="fas fa-search-plus"></i>
            </span>
            <div class="gallery-card-info">
                <span class="gallery-caption">{{ $item->title }}</span>
                @if(!empty($item->description))
                    <span class="gallery-card-desc">{{ Str::limit($item->description, 72) }}</span>
                @endif
            </div>
        </div>
        <span class="gallery-card-frame-accent" aria-hidden="true"></span>
    </div>
</article>
