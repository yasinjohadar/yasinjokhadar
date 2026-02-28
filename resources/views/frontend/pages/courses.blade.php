@extends('frontend.layouts.master')

@section('title', 'جميع الكورسات | ياسين جوخدار')
@section('description', 'جميع الدورات التدريبية المقدمة من المدرب ياسين جوخدار في مجالات تطوير الويب والبرمجة والموبايل.')

@section('content')
    <!-- ============ PAGE BANNER (Courses) ============ -->
    <section class="page-banner page-banner-courses">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-graduation-cap"></i></div>
                <h1 class="page-banner-title">جميع <span>الكورسات</span></h1>
                <p class="page-banner-desc">دورات تدريبية عملية من الصفر إلى الاحتراف في تطوير الويب، البرمجة والموبايل</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>الكورسات</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ COURSES LIST ============ -->
    <section class="section-padding">
        <div class="container">
            <!-- Filter Buttons -->
            <div class="courses-filter animate-on-scroll">
                <a href="{{ route('courses') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">الكل</a>
                @foreach($categories as $category)
                <a href="{{ route('courses', ['category' => $category->slug]) }}" class="filter-btn {{ request('category') == $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="row g-4">
                @forelse($courses as $course)
                <div class="col-lg-3 col-md-6 course-filter-item" data-category="{{ $course->category->slug ?? '' }}">
                    <a href="{{ route('course.show', $course->slug) }}" class="course-card-link">
                        <div class="glass-panel course-card animate-on-scroll">
                            <div class="course-img-wrapper">
                                <img src="{{ $course->image ? route('course.image', ['filename' => basename($course->image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $course->title }}" width="400" height="200" loading="lazy">
                                @if($course->badge)
                                <span class="course-badge">{{ $course->badge }}</span>
                                @endif
                            </div>
                            <div class="course-body">
                                <h5>{{ $course->title }}</h5>
                                <p>{{ $course->short_description ?? Str::limit($course->description ?? '', 100) }}</p>
                            </div>
                            <div class="course-footer">
                                <span><i class="fas fa-users"></i> {{ number_format($course->students_count) }} طالب</span>
                                <span><i class="fas fa-clock"></i> {{ $course->duration_hours ? $course->duration_hours . ' ساعة' : '-' }}</span>
                                <span class="price">${{ number_format($course->price, 2) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">لا توجد كورسات لعرضها حالياً.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2>لم تجد ما تبحث عنه؟</h2>
            <p>تواصل معنا واخبرنا عن المجال الذي تريد تعلمه وسنساعدك</p>
            <a href="{{ route('contact') }}" class="btn-light-custom">
                <i class="fas fa-envelope"></i> تواصل معنا
            </a>
        </div>
    </section>

@endsection