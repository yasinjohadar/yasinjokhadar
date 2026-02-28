@extends('frontend.layouts.master')

@section('title', 'فيديوهاتي | ياسين جوخدار')
@section('description', 'فيديوهات ياسين جوخدار التعليمية - مقاطع من القناة في تطوير الويب، بايثون، Flutter والمزيد.')

@section('content')
    <!-- ============ PAGE BANNER ============ -->
    <section class="page-banner page-banner-blog">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-play-circle"></i></div>
                <h1 class="page-banner-title">فيديوهاتي <span>التعليمية</span></h1>
                <p class="page-banner-desc">مقاطع فيديو تعليمية وعملية من قناتي على يوتيوب في تطوير الويب، البرمجة، وتطبيقات الموبايل</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>الفيديوهات</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ VIDEOS SECTION ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">القناة</span>
                <h2>مقاطع فيديو تعليمية وعملية</h2>
                <p>فيديوهات من قناتي على يوتيوب في تطوير الويب، البرمجة، وتطبيقات الموبايل</p>
            </div>
            <div class="row g-4">
                @forelse($videos as $video)
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel video-card animate-on-scroll animate-delay-{{ ($loop->iteration - 1) % 3 + 1 }}">
                        <a href="{{ $video->video_url }}" target="_blank" rel="noopener noreferrer" class="video-wrapper d-block text-decoration-none">
                            <img src="{{ $video->thumbnail_url ?: $fa . '/images/course-webdev.svg' }}" alt="{{ $video->title }}" width="400" height="200" loading="lazy">
                            <div class="play-btn"><i class="fas fa-play-circle"></i></div>
                        </a>
                        <div class="video-body">
                            <h6>{{ $video->title }}</h6>
                            <span><i class="fas fa-eye"></i> {{ number_format($video->views_count) }} مشاهدة</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-video text-muted" style="font-size:3rem;"></i>
                    <p class="text-muted mt-3">لا توجد فيديوهات حالياً</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-5 animate-on-scroll">
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="btn-primary-custom">
                    <i class="fab fa-youtube"></i> اشترك في القناة
                </a>
            </div>
        </div>
    </section>
@endsection


