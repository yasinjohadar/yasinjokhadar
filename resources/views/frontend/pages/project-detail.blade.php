@extends('frontend.layouts.master')

@section('title', $project->title . ' | مشاريع ياسين جوخدار')
@section('description', $project->short_description ?? Str::limit(strip_tags($project->description ?? ''), 160))

@section('content')
    @php
        $categoryIcons = [
            'تطوير الويب' => 'fas fa-globe',
            'تطبيقات الموبايل' => 'fas fa-mobile-alt',
            'تصميم UI/UX' => 'fas fa-palette',
            'التجارة الإلكترونية' => 'fas fa-shopping-cart',
            'أنظمة إدارة' => 'fas fa-cogs',
        ];
        $icon = $categoryIcons[$project->category?->name ?? ''] ?? 'fas fa-folder-open';
    @endphp

    <!-- Hero -->
    <section class="project-detail-hero">
        <div class="project-detail-hero-img">
            @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" width="1200" height="400" loading="eager">
            @else
                <div class="project-detail-hero-placeholder">
                    <div class="project-detail-hero-icon-ring">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
            @endif
            <div class="project-detail-hero-overlay"></div>
        </div>
        <div class="project-detail-hero-glow project-detail-hero-glow--1" aria-hidden="true"></div>
        <div class="project-detail-hero-glow project-detail-hero-glow--2" aria-hidden="true"></div>

        <div class="container position-relative">
            <nav class="breadcrumb-custom project-detail-breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a><span>/</span>
                <a href="{{ route('projects') }}">المشاريع</a><span>/</span>
                <span>{{ Str::limit($project->title, 40) }}</span>
            </nav>

            <div class="project-detail-hero-caption">
                <span class="project-detail-badge">{{ $project->category?->name ?? 'مشروع' }}</span>
                <h1 class="project-detail-title">{{ $project->title }}</h1>
                @if($project->short_description)
                    <p class="project-detail-lead">{{ $project->short_description }}</p>
                @endif

                @if($project->demo_url || $project->code_url)
                <div class="project-detail-hero-actions">
                    @if($project->demo_url)
                        <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="btn-project-demo">
                            <i class="fas fa-globe"></i> فتح الموقع
                        </a>
                    @endif
                    @if($project->code_url)
                        <a href="{{ $project->code_url }}" target="_blank" rel="noopener noreferrer" class="btn-project-code btn-project-code--hero">
                            <i class="fab fa-github"></i> الكود المصدري
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    <section class="project-detail-body section-padding">
        <div class="container">
            <div class="project-detail-stats animate-on-scroll">
                <div class="project-detail-stat">
                    <span class="project-detail-stat-icon"><i class="{{ $icon }}"></i></span>
                    <div>
                        <span class="project-detail-stat-label">التصنيف</span>
                        <span class="project-detail-stat-value">{{ $project->category?->name ?? 'مشروع' }}</span>
                    </div>
                </div>
                @if(count($project->tags_array))
                <div class="project-detail-stat">
                    <span class="project-detail-stat-icon"><i class="fas fa-tags"></i></span>
                    <div>
                        <span class="project-detail-stat-label">التقنيات</span>
                        <span class="project-detail-stat-value">{{ count($project->tags_array) }} تقنية</span>
                    </div>
                </div>
                @endif
                @if($project->features->isNotEmpty())
                <div class="project-detail-stat">
                    <span class="project-detail-stat-icon"><i class="fas fa-star"></i></span>
                    <div>
                        <span class="project-detail-stat-label">الميزات</span>
                        <span class="project-detail-stat-value">{{ $project->features->count() }} ميزة</span>
                    </div>
                </div>
                @endif
                @if($project->images->isNotEmpty())
                <div class="project-detail-stat">
                    <span class="project-detail-stat-icon"><i class="fas fa-images"></i></span>
                    <div>
                        <span class="project-detail-stat-label">المعرض</span>
                        <span class="project-detail-stat-value">{{ $project->images->count() }} صورة</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="glass-panel project-detail-content animate-on-scroll">
                        @if(count($project->tags_array))
                        <div class="project-detail-tags-wrap">
                            <span class="project-detail-tags-label"><i class="fas fa-code"></i> التقنيات المستخدمة</span>
                            <div class="project-detail-tags">
                                @foreach($project->tags_array as $tag)
                                    <span class="project-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($project->description)
                            <div class="project-detail-block">
                                <h2 class="project-detail-section-title">
                                    <span class="project-detail-section-icon"><i class="fas fa-align-right"></i></span>
                                    عن المشروع
                                </h2>
                                <div class="project-detail-description bd-article">
                                    {!! $project->description !!}
                                </div>
                            </div>
                        @elseif($project->short_description)
                            <div class="project-detail-block">
                                <h2 class="project-detail-section-title">
                                    <span class="project-detail-section-icon"><i class="fas fa-align-right"></i></span>
                                    عن المشروع
                                </h2>
                                <div class="project-detail-intro">
                                    <p>{{ $project->short_description }}</p>
                                </div>
                            </div>
                        @endif

                        @if($project->features->isNotEmpty())
                            <div class="project-detail-block">
                                <h2 class="project-detail-section-title">
                                    <span class="project-detail-section-icon"><i class="fas fa-star"></i></span>
                                    ميزات المشروع
                                </h2>
                                <div class="project-features-grid">
                                    @foreach($project->features as $f)
                                        <div class="project-feature-card">
                                            @if($f->icon)
                                                <div class="project-feature-icon"><i class="{{ $f->icon }}"></i></div>
                                            @endif
                                            <h4 class="project-feature-title">{{ $f->title }}</h4>
                                            @if($f->description)
                                                <p class="project-feature-desc">{{ $f->description }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($project->images->isNotEmpty())
                            <div class="project-detail-block">
                                <h2 class="project-detail-section-title">
                                    <span class="project-detail-section-icon"><i class="fas fa-images"></i></span>
                                    معرض الصور
                                </h2>
                                <div class="project-gallery-grid">
                                    @foreach($project->images as $img)
                                        <div class="gallery-item project-gallery-item">
                                            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?? $project->title }}" loading="lazy">
                                            @if($img->caption)
                                                <span class="project-gallery-caption">{{ $img->caption }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($project->videos->isNotEmpty())
                            <div class="project-detail-block">
                                <h2 class="project-detail-section-title">
                                    <span class="project-detail-section-icon"><i class="fas fa-video"></i></span>
                                    فيديوهات المشروع
                                </h2>
                                <div class="project-videos-grid">
                                    @foreach($project->videos as $video)
                                        @if($video->embed_url)
                                            <div class="project-video-wrap">
                                                @if($video->title)
                                                    <h5 class="project-video-title">{{ $video->title }}</h5>
                                                @endif
                                                <div class="project-video-embed">
                                                    <iframe src="{{ $video->embed_url }}" title="{{ $video->title ?? 'فيديو' }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="project-detail-cta">
                            <div class="project-detail-cta-inner">
                                <div class="project-detail-cta-content">
                                    <span class="project-detail-cta-icon"><i class="fas fa-rocket"></i></span>
                                    <div>
                                        <h3>هل لديك مشروع مماثل؟</h3>
                                        <p>تواصل معي لتحويل فكرتك إلى منتج رقمي احترافي</p>
                                    </div>
                                </div>
                                <a href="{{ route('contact') }}" class="btn-primary-custom project-detail-cta-btn">
                                    <i class="fas fa-paper-plane"></i> تواصل معي
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4">
                    <div class="project-detail-sidebar-wrap">
                        @if($project->demo_url || $project->code_url)
                        <div class="glass-panel project-detail-actions-card animate-on-scroll">
                            <h4 class="project-detail-sidebar-title">
                                <i class="fas fa-link"></i> روابط المشروع
                            </h4>
                            <div class="project-detail-sidebar-links">
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="project-sidebar-link project-sidebar-link--primary">
                                        <span class="project-sidebar-link-icon"><i class="fas fa-globe"></i></span>
                                        <span>
                                            <strong>فتح الموقع</strong>
                                            <small>زيارة المشروع مباشرة</small>
                                        </span>
                                        <i class="fas fa-arrow-left project-sidebar-link-arrow"></i>
                                    </a>
                                @endif
                                @if($project->code_url)
                                    <a href="{{ $project->code_url }}" target="_blank" rel="noopener noreferrer" class="project-sidebar-link">
                                        <span class="project-sidebar-link-icon"><i class="fab fa-github"></i></span>
                                        <span>
                                            <strong>الكود المصدري</strong>
                                            <small>عرض على GitHub</small>
                                        </span>
                                        <i class="fas fa-arrow-left project-sidebar-link-arrow"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($relatedProjects->isNotEmpty())
                        <div class="glass-panel project-detail-sidebar animate-on-scroll">
                            <h4 class="project-detail-sidebar-title">
                                <i class="fas fa-folder-open"></i> مشاريع ذات صلة
                            </h4>
                            <ul class="project-related-list">
                                @foreach($relatedProjects as $rel)
                                    <li>
                                        <a href="{{ route('projects.show', $rel->slug) }}" class="project-related-card">
                                            <span class="project-related-thumb">
                                                @if($rel->image)
                                                    <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title }}" loading="lazy">
                                                @else
                                                    <i class="fas fa-folder-open"></i>
                                                @endif
                                            </span>
                                            <span class="project-related-info">
                                                <strong>{{ $rel->title }}</strong>
                                                @if($rel->short_description)
                                                    <small>{{ Str::limit($rel->short_description, 55) }}</small>
                                                @endif
                                            </span>
                                            <i class="fas fa-chevron-left project-related-arrow"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('projects') }}" class="btn-outline-custom project-detail-all-btn">
                                <i class="fas fa-th-large"></i> جميع المشاريع
                            </a>
                        </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
