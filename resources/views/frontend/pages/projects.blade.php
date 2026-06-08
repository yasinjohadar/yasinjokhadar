@extends('frontend.layouts.master')

@section('title', 'المشاريع البرمجية | ياسين جوخدار')
@section('description', 'مشاريعي البرمجية — معرض مشاريع ياسين جوخدار في تطوير الويب، تطبيقات الموبايل والأنظمة البرمجية مع روابط مباشرة ومصدر الكود.')

@section('content')
    <!-- ============ PAGE BANNER ============ -->
    <section class="page-banner page-banner-projects">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-folder-open"></i></div>
                <h1 class="page-banner-title">مشاريعي <span>البرمجية</span></h1>
                <p class="page-banner-desc">معرض مشاريع تطوير الويب، تطبيقات الموبايل والأنظمة — مع روابط مباشرة ومصدر الكود</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>المشاريع</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ PROJECTS LIST ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="projects-filter animate-on-scroll">
                <button class="filter-btn active" data-filter="all">الكل</button>
                @foreach($categories as $cat)
                    <button class="filter-btn" data-filter="{{ $cat->slug }}">{{ $cat->name }}</button>
                @endforeach
            </div>

            <div class="row g-4">
                @forelse($projects as $project)
                    @php
                        $slug = $project->category->slug ?? 'other';
                        $badge = $project->category->name ?? 'مشروع';
                        $icon = 'fas fa-folder-open';
                        if ($slug === 'web') $icon = 'fas fa-globe';
                        elseif ($slug === 'mobile') $icon = 'fas fa-mobile-alt';
                        elseif ($slug === 'devops') $icon = 'fas fa-cloud';
                    @endphp
                    <div class="col-lg-4 col-md-6 project-filter-item" data-category="{{ $slug }}">
                        <article class="glass-panel project-card animate-on-scroll">
                            <a href="{{ route('projects.show', $project->slug) }}" class="project-card-thumb-link">
                                <div class="project-card-thumb">
                                    @if($project->image_url)
                                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="project-card-img" width="1920" height="1080" loading="lazy">
                                    @else
                                        <div class="project-card-thumb-placeholder">
                                            <i class="{{ $icon }}"></i>
                                        </div>
                                    @endif
                                    <div class="project-card-thumb-overlay">
                                        <span class="project-card-view-hint"><i class="fas fa-eye"></i> عرض التفاصيل</span>
                                    </div>
                                    <span class="project-card-badge">{{ $badge }}</span>
                                </div>
                            </a>
                            <div class="project-card-body">
                                <h3 class="project-card-title">
                                    <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                                </h3>
                                <p class="project-card-desc">{{ $project->short_description ?? Str::limit(strip_tags($project->description), 120) }}</p>
                                @if(count($project->tags_array))
                                <div class="project-card-tags">
                                    @foreach($project->tags_array as $tag)
                                        <span>{{ $tag }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="project-card-actions">
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn-project btn-project-primary">
                                    <i class="fas fa-folder-open"></i> عرض المشروع
                                </a>
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="btn-project btn-project-outline">
                                        <i class="fas fa-globe"></i> فتح الموقع
                                    </a>
                                @endif
                                @if($project->code_url)
                                    <a href="{{ $project->code_url }}" target="_blank" rel="noopener noreferrer" class="btn-project btn-project-outline">
                                        <i class="fab fa-github"></i> الكود
                                    </a>
                                @endif
                            </div>
                        </article>
                    </div>
                @empty
                    <p class="text-center text-muted mt-4">لا توجد مشاريع مضافة بعد.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2>هل تريد تنفيذ مشروع مماثل؟</h2>
            <p>تواصل معنا لمناقشة فكرتك والحصول على عرض tailored لاحتياجاتك</p>
            <a href="{{ route('contact') }}" class="btn-light-custom">
                <i class="fas fa-paper-plane"></i> تواصل معنا
            </a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.projects-filter .filter-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var filter = this.getAttribute('data-filter');
        document.querySelectorAll('.projects-filter .filter-btn').forEach(function(b) { b.classList.remove('active'); });
        this.classList.add('active');
        document.querySelectorAll('.project-filter-item').forEach(function(item) {
            var cat = item.getAttribute('data-category');
            item.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
        });
    });
});
</script>
@endsection
