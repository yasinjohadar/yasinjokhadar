@php
    $title = $title ?? 'تقنيات نعتمد عليها';
    $subtitle = $subtitle ?? '';
    $technologies = $technologies ?? [];
    $sectionClass = $sectionClass ?? '';
@endphp

<section class="section-padding service-tech-section {{ $sectionClass }}">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-badge">التقنيات</span>
            <h2>{{ $title }}</h2>
            @if($subtitle)
            <p>{{ $subtitle }}</p>
            @endif
        </div>
        <div class="glass-panel service-tech-wrap animate-on-scroll">
            @include('frontend.partials.service-tech-grid', ['technologies' => $technologies])
        </div>
    </div>
</section>
