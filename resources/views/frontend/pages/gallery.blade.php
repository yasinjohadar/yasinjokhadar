@extends('frontend.layouts.master')

@section('title', 'معرض الصور | ياسين جوخدار')
@section('description', 'صور من نشاطات ياسين جوخدار - لقطات من الفعاليات والورشات والدورات التدريبية.')

@section('content')
    <!-- ============ PAGE BANNER ============ -->
    <section class="page-banner page-banner-blog">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-images"></i></div>
                <h1 class="page-banner-title">معرض <span>الصور</span></h1>
                <p class="page-banner-desc">لقطات من الفعاليات والورشات والدورات التدريبية</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>معرض الصور</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ GALLERY SECTION ============ -->
    <section class="section-padding gallery-section gallery-section--page">
        <div class="gallery-section-glow gallery-section-glow-left" aria-hidden="true"></div>
        <div class="gallery-section-glow gallery-section-glow-right" aria-hidden="true"></div>
        <div class="container position-relative">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">معرض الصور</span>
                <h2>صور من نشاطاتي</h2>
                <p>لقطات من الفعاليات والورشات والدورات التدريبية — اضغط على أي صورة للتكبير</p>
            </div>
            <div class="gallery-grid gallery-grid--page animate-on-scroll">
                @forelse($galleryImages as $item)
                    @include('frontend.partials.gallery-item', ['item' => $item, 'featuredSpan' => true])
                @empty
                <div class="gallery-empty">
                    <i class="fas fa-images"></i>
                    <p>لا توجد صور في المعرض حالياً</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
