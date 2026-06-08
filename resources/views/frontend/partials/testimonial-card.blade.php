@php
    $delayClass = $delayClass ?? ('animate-delay-' . ($loop->iteration ?? 1));
@endphp

<div class="glass-panel testimonial-card animate-on-scroll {{ $delayClass }}">
    <div class="testimonial-quote-icon" aria-hidden="true"><i class="fas fa-quote-right"></i></div>
    <div class="stars">
        @for($i = 1; $i <= 5; $i++)
            @if($i <= $testimonial->rating)
                <i class="fas fa-star"></i>
            @else
                <i class="far fa-star"></i>
            @endif
        @endfor
    </div>
    <p class="quote-text">{{ $testimonial->quote }}</p>
    <div class="testimonial-divider"></div>
    <div class="student-info">
        @if($testimonial->avatar)
            <img
                src="{{ asset('storage/' . $testimonial->avatar) }}"
                alt="{{ $testimonial->student_name }}"
                class="student-avatar"
                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
            >
            <div class="student-avatar student-avatar-fallback" style="display:none;">
                <span>{{ mb_substr($testimonial->student_name, 0, 1) }}</span>
            </div>
        @else
            <div class="student-avatar student-avatar-fallback">
                <span>{{ mb_substr($testimonial->student_name, 0, 1) }}</span>
            </div>
        @endif
        <div class="student-details">
            <div class="student-name">{{ $testimonial->student_name }}</div>
            @if($testimonial->student_title)
                <div class="student-role">{{ $testimonial->student_title }}</div>
            @endif
            @if($testimonial->course_name)
                <div class="student-course"><i class="fas fa-graduation-cap"></i> {{ $testimonial->course_name }}</div>
            @endif
        </div>
    </div>
</div>
