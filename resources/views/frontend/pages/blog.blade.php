@extends('frontend.layouts.master')

@section('title', 'المدونة | ياسين جوخدار')
@section('description', 'مدونة ياسين جوخدار - مقالات تقنية وتعليمية في عالم البرمجة وتطوير الويب والموبايل والذكاء الاصطناعي.')

@section('content')
    <!-- ============ PAGE BANNER (Blog) ============ -->
    <section class="page-banner page-banner-blog">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-blog"></i></div>
                <h1 class="page-banner-title">المدونة <span>التقنية</span></h1>
                <p class="page-banner-desc">مقالات وتدوينات في البرمجة، تطوير الويب، الموبايل والذكاء الاصطناعي</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>المدونة</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ BLOG FILTER + SEARCH ============ -->
    <section class="section-padding" style="padding-top: 30px;">
        <div class="container">
            <div class="glass-panel animate-on-scroll" style="padding: 25px 30px; margin-bottom: 40px;">
                <div class="row align-items-center g-3">
                    <div class="col-lg-5">
                        <div style="position: relative;">
                            <input type="text" class="form-control" placeholder="ابحث في المدونة..." id="blogSearch"
                                style="background: var(--clr-surface); border: 1px solid var(--clr-border); color: var(--clr-text); padding: 12px 18px 12px 45px; border-radius: var(--radius-md); font-family: var(--font-family);">
                            <i class="fas fa-search"
                                style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--clr-text-muted);"></i>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="courses-filter" style="margin-bottom: 0; justify-content: flex-start;">
                            <button class="filter-btn active" data-filter="all">الكل</button>
                            @foreach($categories as $cat)
                            <button class="filter-btn" data-filter="{{ $cat->slug }}">{{ $cat->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ FEATURED POST ============ -->
            @if($featuredPost)
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <a href="{{ route('blog.show', $featuredPost->slug) }}" style="text-decoration:none;color:inherit;display:block;">
                        <div class="glass-panel animate-on-scroll" style="overflow: hidden; border-radius: var(--radius-xl);">
                            <div class="row g-0 align-items-stretch">
                                <div class="col-lg-6">
                                    <div style="height: 100%; min-height: 350px; position: relative; overflow: hidden;">
                                        <img src="{{ $featuredPost->featured_image ? route('blog.image', ['filename' => basename($featuredPost->featured_image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $featuredPost->featured_image_alt ?? $featuredPost->title }}" width="400" height="200" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div style="position: absolute; top: 20px; right: 20px; background: var(--clr-primary); color: #fff; padding: 5px 18px; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                                            <i class="fas fa-star"></i> مقال مميز
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div style="padding: 40px; display: flex; flex-direction: column; justify-content: center; height: 100%;">
                                        <div style="display: flex; gap: 15px; font-size: 0.82rem; color: var(--clr-text-muted); margin-bottom: 15px; flex-wrap: wrap;">
                                            <span><i class="fas fa-calendar-alt"></i> {{ $featuredPost->published_at?->translatedFormat('d F Y') }}</span>
                                            <span><i class="fas fa-user"></i> {{ $featuredPost->author?->name ?? 'ياسين جوخدار' }}</span>
                                            <span><i class="fas fa-eye"></i> {{ number_format($featuredPost->views_count) }} مشاهدة</span>
                                            <span><i class="fas fa-comments"></i> {{ $featuredPost->comments_count }} تعليق</span>
                                        </div>
                                        <span style="display: inline-block; background: var(--clr-surface); padding: 3px 14px; border-radius: 50px; font-size: 0.78rem; color: var(--clr-primary); font-weight: 600; width: fit-content; margin-bottom: 12px;">{{ $featuredPost->category?->name ?? '—' }}</span>
                                        <h3 style="font-weight: 800; margin-bottom: 15px; font-size: 1.5rem; line-height: 1.6;">{{ $featuredPost->title }}</h3>
                                        <p style="color: var(--clr-text-secondary); font-size: 0.95rem; line-height: 1.9; margin-bottom: 20px;">
                                            {{ Str::limit(strip_tags($featuredPost->excerpt ?? $featuredPost->content), 180) }}
                                        </p>
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <span class="btn-primary-custom" style="padding: 10px 25px; font-size: 0.9rem;">
                                                اقرأ المقال <i class="fas fa-arrow-left"></i>
                                            </span>
                                            <span style="font-size: 0.82rem; color: var(--clr-text-muted);"><i class="fas fa-clock"></i> {{ $featuredPost->reading_time ?? '—' }} دقيقة قراءة</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif

            <!-- ============ BLOG POSTS GRID ============ -->
            <div class="row g-4">
                @forelse($posts as $post)
                <div class="col-lg-4 col-md-6 course-filter-item" data-category="{{ $post->category?->slug ?? 'all' }}">
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-link" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="glass-panel blog-card animate-on-scroll animate-delay-{{ ($loop->iteration % 3) ?: 3 }}">
                            <div class="blog-img-wrapper">
                                <img src="{{ $post->featured_image ? route('blog.image', ['filename' => basename($post->featured_image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $post->featured_image_alt ?? $post->title }}" width="400" height="200" loading="lazy">
                                <div style="position: absolute; top: 12px; right: 12px; background: var(--clr-primary); color: #fff; padding: 3px 12px; border-radius: 50px; font-size: 0.72rem; font-weight: 600;">
                                    {{ $post->category?->name ?? '—' }}
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> {{ $post->published_at?->translatedFormat('d F Y') }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $post->reading_time ?? '—' }} دقيقة</span>
                                </div>
                                <h5>{{ $post->title }}</h5>
                                <p>{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 100) }}</p>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--clr-border);">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <img src="{{ $fa }}/images/logo.svg" alt="الكاتب" width="30" height="30" loading="lazy" style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid var(--clr-primary);">
                                        <span style="font-size: 0.8rem; font-weight: 600;">{{ $post->author?->name ?? 'ياسين جوخدار' }}</span>
                                    </div>
                                    <span class="read-more" style="margin-top: 0;">المزيد <i class="fas fa-arrow-left"></i></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">لا توجد تدوينات حالياً.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="animate-on-scroll" style="display: flex; justify-content: center; margin-top: 50px;">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </section>

    <!-- ============ NEWSLETTER ============ -->
    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2><i class="fas fa-envelope-open-text" style="margin-left: 10px;"></i> اشترك في النشرة البريدية</h2>
            <p>كن أول من يعرف عن المقالات والدورات الجديدة</p>
            <div class="newsletter-cta-wrapper">
                @include('frontend.partials.newsletter-form', ['source' => 'blog', 'variant' => 'cta'])
            </div>
        </div>
    </section>
@endsection
