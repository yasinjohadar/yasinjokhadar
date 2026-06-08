@php
    $technologies = $technologies ?? [];
    $columns = $columns ?? 'col-6 col-md-4 col-lg-3';
@endphp

<div class="service-tech-grid">
    <div class="row g-3">
        @foreach($technologies as $tech)
        <div class="{{ $columns }}">
            <div class="service-tech-card" style="--tech-color: {{ $tech['color'] ?? '#E60000' }}">
                <span class="service-tech-card-icon">
                    <i class="{{ $tech['icon'] ?? 'fas fa-code' }}"></i>
                </span>
                <span class="service-tech-card-name">{{ $tech['name'] }}</span>
                @if(!empty($tech['hint']))
                <span class="service-tech-card-hint">{{ $tech['hint'] }}</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
