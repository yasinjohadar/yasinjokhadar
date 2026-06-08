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
    <section class="section-padding blog-listing-section">
        <div class="container">
            <div class="blog-filter-bar glass-panel animate-on-scroll">
                <div class="blog-filter-header">
                    <div class="blog-filter-label">
                        <span class="blog-filter-label-icon"><i class="fas fa-sliders-h"></i></span>
                        <div>
                            <strong>تصفية المقالات</strong>
                            <small>ابحث أو اختر التصنيف المناسب</small>
                        </div>
                    </div>
                    <p class="blog-filter-status" id="blogFilterStatus" aria-live="polite"></p>
                </div>

                <div class="blog-filter-toolbar">
                    <div class="blog-filter-search">
                        <i class="fas fa-search blog-filter-search-icon" aria-hidden="true"></i>
                        <input
                            type="search"
                            id="blogSearch"
                            placeholder="ابحث في المدونة..."
                            autocomplete="off"
                            aria-label="ابحث في المدونة"
                        >
                        <button type="button" class="blog-filter-search-clear" id="blogSearchClear" aria-label="مسح البحث" hidden>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="blog-filter-categories-wrap">
                        <div class="blog-filter-categories" id="blogFilterCategories" role="tablist" aria-label="تصنيفات المدونة">
                            <button type="button" class="blog-filter-pill active" data-filter="all" role="tab" aria-selected="true">
                                <i class="fas fa-th-large"></i>
                                <span>الكل</span>
                            </button>
                            @foreach($categories as $cat)
                            <button
                                type="button"
                                class="blog-filter-pill"
                                data-filter="{{ $cat->slug }}"
                                role="tab"
                                aria-selected="false"
                                @if($cat->color) style="--pill-color: {{ $cat->color }}" @endif
                            >
                                @if($cat->icon)<i class="{{ $cat->icon }}"></i>@endif
                                <span>{{ $cat->name }}</span>
                                @if($cat->published_posts_count > 0)
                                <span class="blog-filter-count">{{ $cat->published_posts_count }}</span>
                                @endif
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ FEATURED POST ============ -->
            @if($featuredPost)
            <div class="row g-4 mb-5" id="blogFeatured" data-category="{{ $featuredPost->category?->slug ?? 'all' }}" data-search="{{ $featuredPost->title }}">
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
            <div class="row g-4" id="blogPostsGrid">
                @forelse($posts as $post)
                <div class="col-lg-4 col-md-6 blog-filter-item" data-category="{{ $post->category?->slug ?? 'all' }}" data-search="{{ $post->title }}">
                    @include('frontend.partials.blog-card', [
                        'post' => $post,
                        'showAuthor' => true,
                        'excerptLimit' => 100,
                        'delayClass' => 'animate-delay-' . (($loop->iteration % 3) ?: 3),
                    ])
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">لا توجد تدوينات حالياً.</p>
                </div>
                @endforelse
            </div>

            <div class="blog-filter-empty" id="blogFilterEmpty" hidden>
                <span class="blog-filter-empty-icon"><i class="fas fa-search"></i></span>
                <h3>لا توجد نتائج</h3>
                <p>جرّب كلمة بحث مختلفة أو اختر تصنيفاً آخر</p>
                <button type="button" class="btn-outline-custom" id="blogFilterReset">
                    <i class="fas fa-redo"></i> إعادة التصفية
                </button>
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
