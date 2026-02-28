@extends('frontend.layouts.master')

@section('title', 'آراء الطلاب | ياسين جوخدار')
@section('description', 'آراء وتجارب طلاب ياسين جوخدار - ماذا يقول طلاب الدورات التدريبية عن التجربة والنتائج.')

@section('content')
    <!-- ============ PAGE BANNER ============ -->
    <section class="page-banner page-banner-testimonials">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-quote-right"></i></div>
                <h1 class="page-banner-title">آراء <span>الطلاب</span></h1>
                <p class="page-banner-desc">تجارب حقيقية وتقييمات من طلاب استفادوا من دوراتنا التدريبية</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>آراء الطلاب</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ TESTIMONIALS SECTION ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">تجارب حقيقية</span>
                <h2>ماذا يقول طلابنا</h2>
                <p>آراء وتجارب بعض الطلاب الذين استفادوا من دوراتنا التدريبية</p>
            </div>

            @if($testimonials->count())
                <div class="row g-4">
                    @foreach($testimonials as $testimonial)
                        <div class="col-lg-4 col-md-6">
                            <div class="glass-panel testimonial-card animate-on-scroll animate-delay-{{ ($loop->iteration % 3) + 1 }}">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="quote-text">"{{ $testimonial->quote }}"</p>
                                <div class="student-info">
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->student_name }}" class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width:40px;height:40px;">
                                                <span class="fw-bold">{{ mb_substr($testimonial->student_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="student-name">{{ $testimonial->student_name }}</div>
                                            @if($testimonial->student_title)
                                                <div class="student-role">{{ $testimonial->student_title }}</div>
                                            @endif
                                            @if($testimonial->course_name)
                                                <div class="student-course text-muted small">{{ $testimonial->course_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($testimonials->hasPages())
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $testimonials->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <p class="text-muted mb-3">لا توجد آراء طلاب متاحة حالياً، سيتم عرض الآراء هنا عند إضافتها من لوحة التحكم.</p>
                    <a href="{{ route('courses') }}" class="btn-primary-custom">
                        <i class="fas fa-graduation-cap"></i> تصفّح الكورسات
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
