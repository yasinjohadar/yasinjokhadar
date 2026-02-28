@extends('frontend.layouts.master')

@section('title', $project->title . ' | مشاريع ياسين جوخدار')
@section('description', $project->short_description ?? Str::limit(strip_tags($project->description ?? ''), 160))

@section('content')
    <!-- Hero -->
    <section class="project-detail-hero">
        <div class="project-detail-hero-img">
            @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" width="1200" height="400" loading="eager">
            @else
                <div class="project-detail-hero-placeholder"><i class="fas fa-folder-open"></i></div>
            @endif
            <div class="project-detail-hero-overlay"></div>
        </div>
        <div class="container position-relative">
            <div class="project-detail-hero-caption">
                <span class="project-detail-badge">{{ $project->category?->name ?? 'مشروع' }}</span>
                <h1 class="project-detail-title">{{ $project->title }}</h1>
                @if($project->short_description)
                    <p class="project-detail-lead">{{ $project->short_description }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="section-padding" style="padding-top: 2rem;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="glass-panel project-detail-content animate-on-scroll">
                        <nav class="breadcrumb-custom mb-4">
                            <a href="{{ route('home') }}">الرئيسية</a><span>/</span>
                            <a href="{{ route('projects') }}">المشاريع</a><span>/</span>
                            <span>{{ $project->title }}</span>
                        </nav>

                        <div class="project-detail-meta mb-4">
                            @if($project->tags_array)
                                <div class="project-detail-tags">
                                    @foreach($project->tags_array as $tag)
                                        <span class="project-tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="project-detail-links mt-2">
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-project-demo">
                                        <i class="fas fa-external-link-alt"></i> معاينة حية
                                    </a>
                                @endif
                                @if($project->code_url)
                                    <a href="{{ $project->code_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-project-code">
                                        <i class="fab fa-github"></i> الكود
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if($project->description)
                            <div class="project-detail-description bd-article mb-5">
                                {!! $project->description !!}
                            </div>
                        @endif

                        @if($project->features->isNotEmpty())
                            <h3 class="project-detail-section-title"><i class="fas fa-star"></i> ميزات المشروع</h3>
                            <div class="project-features-grid mb-5">
                                @foreach($project->features as $f)
                                    <div class="project-feature-card glass-panel">
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
                        @endif

                        @if($project->images->isNotEmpty())
                            <h3 class="project-detail-section-title"><i class="fas fa-images"></i> معرض الصور</h3>
                            <div class="project-gallery-grid mb-5">
                                @foreach($project->images as $img)
                                    <div class="gallery-item project-gallery-item" style="cursor:pointer; border-radius: var(--radius-lg); overflow: hidden; height: 220px;">
                                        <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->caption ?? $project->title }}" loading="lazy" style="width:100%; height:100%; object-fit: cover;">
                                        @if($img->caption)
                                            <span class="project-gallery-caption">{{ $img->caption }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($project->videos->isNotEmpty())
                            <h3 class="project-detail-section-title"><i class="fas fa-video"></i> فيديوهات المشروع</h3>
                            <div class="project-videos-grid mb-5">
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
                        @endif

                        <div class="project-detail-cta mt-4">
                            <a href="{{ route('contact') }}" class="btn-light-custom">
                                <i class="fas fa-paper-plane"></i> تواصل معي لمشروع مماثل
                            </a>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4">
                    @if($relatedProjects->isNotEmpty())
                        <div class="glass-panel project-detail-sidebar animate-on-scroll">
                            <h4 class="mb-3"><i class="fas fa-folder-open"></i> مشاريع ذات صلة</h4>
                            <ul class="list-unstyled mb-0">
                                @foreach($relatedProjects as $rel)
                                    <li class="mb-3">
                                        <a href="{{ route('projects.show', $rel->slug) }}" class="project-related-link">
                                            {{ $rel->title }}
                                        </a>
                                        @if($rel->short_description)
                                            <p class="text-muted small mb-0 mt-1">{{ Str::limit($rel->short_description, 60) }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('projects') }}" class="btn btn-outline-primary btn-sm mt-2">جميع المشاريع</a>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection
