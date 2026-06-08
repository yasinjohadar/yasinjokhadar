@extends('frontend.layouts.master')

@section('title', 'حول المدرب | ياسين جوخدار')
@section('description', 'تعرف على المدرب ياسين جوخدار - خبرة واسعة في تطوير البرمجيات والتدريب التقني.')

@section('content')
    @php
        $aboutStats = [
            ['icon' => 'fas fa-graduation-cap', 'count' => 50, 'label' => 'دورة تدريبية'],
            ['icon' => 'fas fa-users', 'count' => 5000, 'label' => 'طالب وطالبة'],
            ['icon' => 'fas fa-laptop-code', 'count' => 200, 'label' => 'مشروع منجز'],
            ['icon' => 'fas fa-certificate', 'count' => 10, 'label' => 'شهادة معتمدة'],
        ];

        $aboutSpecialties = [
            [
                'title' => 'تطوير الواجهات الأمامية',
                'icon' => 'fas fa-code',
                'desc' => 'بناء واجهات مستخدم تفاعلية وجذابة باستخدام HTML5, CSS3, JavaScript, React.js, Vue.js و Next.js مع التركيز على التجاوب وتجربة المستخدم.',
                'tags' => [
                    ['name' => 'React', 'icon' => 'fab fa-react', 'color' => '#61DAFB'],
                    ['name' => 'Vue.js', 'icon' => 'fab fa-vuejs', 'color' => '#42b883'],
                    ['name' => 'Next.js', 'icon' => 'fas fa-layer-group', 'color' => '#1a1a2e'],
                    ['name' => 'Bootstrap', 'icon' => 'fab fa-bootstrap', 'color' => '#7952B3'],
                ],
                'route' => 'web',
            ],
            [
                'title' => 'تطوير الخوادم وAPI',
                'icon' => 'fas fa-server',
                'desc' => 'تصميم وبناء خوادم وواجهات برمجة التطبيقات RESTful APIs باستخدام Node.js, Express, NestJS, Python Django, وقواعد بيانات متنوعة.',
                'tags' => [
                    ['name' => 'Node.js', 'icon' => 'fab fa-node-js', 'color' => '#339933'],
                    ['name' => 'Laravel', 'icon' => 'fab fa-laravel', 'color' => '#FF2D20'],
                    ['name' => 'Django', 'icon' => 'fab fa-python', 'color' => '#3776AB'],
                    ['name' => 'MySQL', 'icon' => 'fas fa-database', 'color' => '#4479A1'],
                ],
                'route' => 'servers',
            ],
            [
                'title' => 'تطوير تطبيقات الموبايل',
                'icon' => 'fas fa-mobile-alt',
                'desc' => 'تطوير تطبيقات موبايل متعددة المنصات لنظامي Android و iOS باستخدام Flutter و React Native مع واجهات مستخدم احترافية.',
                'tags' => [
                    ['name' => 'Flutter', 'icon' => 'fas fa-mobile-alt', 'color' => '#02569B'],
                    ['name' => 'React Native', 'icon' => 'fab fa-react', 'color' => '#61DAFB'],
                    ['name' => 'Dart', 'icon' => 'fas fa-code', 'color' => '#0175C2'],
                    ['name' => 'Firebase', 'icon' => 'fas fa-fire', 'color' => '#FFCA28'],
                ],
                'route' => 'mobile',
            ],
        ];
    @endphp

    <!-- ============ PAGE BANNER (حول المدرب) ============ -->
    <section class="page-banner page-banner-about">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-user-tie"></i></div>
                <h1 class="page-banner-title">حول <span>المدرب</span></h1>
                <p class="page-banner-desc">تعرف على ياسين جوخدار — مدرب ومطور برمجيات بخبرة +10 سنوات في التدريب والتطوير</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>حول المدرب</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ ABOUT INTRO ============ -->
    <section class="section-padding about-intro-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="about-profile-wrap animate-on-scroll">
                        <div class="about-profile-glow about-profile-glow--1" aria-hidden="true"></div>
                        <div class="about-profile-glow about-profile-glow--2" aria-hidden="true"></div>
                        <div class="hero-image-wrapper about-profile-image">
                            <div class="hero-ring"></div>
                            <img src="{{ $fa }}/images/hero.png" alt="ياسين جوخدار" class="hero-img" width="350" height="350" loading="lazy">
                        </div>
                        <div class="about-profile-badge">
                            <i class="fas fa-award"></i>
                            <span>+10 سنوات خبرة</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-intro-content animate-on-scroll">
                        <span class="section-badge about-intro-badge">من أنا؟</span>
                        <h2 class="about-intro-title">ياسين جوخدار</h2>
                        <p class="about-intro-text">
                            مدرب ومطور برمجيات سوري الجنسية، شغوف بعالم التكنولوجيا والبرمجة منذ أكثر من 10 سنوات.
                            بدأت مسيرتي في عالم تطوير الويب ثم توسعت لتشمل تطوير تطبيقات الموبايل، قواعد البيانات،
                            وأنظمة إدارة المحتوى.
                        </p>
                        <p class="about-intro-text">
                            أؤمن بأن التعليم العملي هو أفضل طريقة لاكتساب المهارات البرمجية، لذلك أركز في دوراتي
                            التدريبية على المشاريع الحقيقية والتطبيق العملي. قمت بتدريب آلاف الطلاب في مختلف مجالات البرمجة.
                        </p>

                        <div class="about-highlight">
                            <i class="fas fa-quote-right"></i>
                            <p>هدفي هو تحويل المعرفة التقنية إلى مهارات عملية تُمكّن كل متعلم من بناء مشاريع حقيقية بثقة.</p>
                        </div>

                        <div class="row g-3 about-stats-grid">
                            @foreach($aboutStats as $index => $stat)
                            <div class="col-sm-6">
                                <div class="about-stat-card glass-panel animate-on-scroll animate-delay-{{ ($index % 4) + 1 }}">
                                    <span class="about-stat-icon"><i class="{{ $stat['icon'] }}"></i></span>
                                    <span class="about-stat-num counter-num" data-count="{{ $stat['count'] }}">0</span>
                                    <span class="about-stat-label">{{ $stat['label'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TIMELINE ============ -->
    <section class="section-padding about-journey-section">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">المسيرة المهنية</span>
                <h2>رحلتي في عالم البرمجة</h2>
                <p>محطات بارزة في مسيرتي المهنية والتعليمية</p>
            </div>

            @if($journeyCategories->isNotEmpty())
            <div class="journey-filter-bar glass-panel animate-on-scroll" id="journeyFilter">
                <div class="journey-filter-categories">
                    <button type="button" class="journey-filter-btn {{ !$categorySlug ? 'active' : '' }}" data-category="">
                        <i class="fas fa-th-large"></i> الكل
                    </button>
                    @foreach($journeyCategories as $cat)
                        <button type="button" class="journey-filter-btn {{ $categorySlug === $cat->slug ? 'active' : '' }}" data-category="{{ $cat->slug }}">
                            @if($cat->icon)<i class="{{ $cat->icon }}"></i>@endif
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="timeline animate-on-scroll" id="journeyTimeline">
                        @forelse($journeyMilestones as $m)
                            <div class="timeline-item" data-category="{{ $m->category->slug }}">
                                <div class="timeline-card glass-panel">
                                    <span class="year">{{ $m->year }}</span>
                                    @if($m->category)
                                    <span class="timeline-category">{{ $m->category->name }}</span>
                                    @endif
                                    <h5>{{ $m->title }}</h5>
                                    @if($m->description)
                                        <p>{{ $m->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 journey-empty-all" id="journeyEmptyAll">
                                <p class="text-muted">لا توجد محطات مسيرة لعرضها حالياً.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="text-center py-5 journey-empty-filtered" id="journeyEmptyFiltered" style="display:none;">
                        <p class="text-muted">لا توجد محطات في هذا التصنيف.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $aboutSkillCategories = [
            [
                'title' => 'المهارات البرمجية — اللغات',
                'icon' => 'fas fa-code',
                'accent' => '#E60000',
                'skills' => [
                    ['name' => 'JavaScript / TypeScript', 'level' => 92, 'icon' => 'fab fa-js-square', 'color' => '#F7DF1E'],
                    ['name' => 'Python', 'level' => 88, 'icon' => 'fab fa-python', 'color' => '#3776AB'],
                    ['name' => 'HTML5 / CSS3 / SASS', 'level' => 95, 'icon' => 'fab fa-html5', 'color' => '#E34F26'],
                    ['name' => 'PHP', 'level' => 80, 'icon' => 'fab fa-php', 'color' => '#777BB4'],
                    ['name' => 'Dart', 'level' => 82, 'icon' => 'fas fa-code', 'color' => '#0175C2'],
                ],
            ],
            [
                'title' => 'أطر العمل والمكتبات',
                'icon' => 'fas fa-puzzle-piece',
                'accent' => '#61DAFB',
                'skills' => [
                    ['name' => 'React.js', 'level' => 90, 'icon' => 'fab fa-react', 'color' => '#61DAFB'],
                    ['name' => 'Node.js / Express', 'level' => 88, 'icon' => 'fab fa-node-js', 'color' => '#339933'],
                    ['name' => 'Flutter', 'level' => 85, 'icon' => 'fas fa-mobile-alt', 'color' => '#02569B'],
                    ['name' => 'Bootstrap / Tailwind', 'level' => 92, 'icon' => 'fab fa-bootstrap', 'color' => '#7952B3'],
                    ['name' => 'Next.js / Nuxt', 'level' => 82, 'icon' => 'fas fa-layer-group', 'color' => '#1a1a2e'],
                ],
            ],
            [
                'title' => 'قواعد البيانات',
                'icon' => 'fas fa-database',
                'accent' => '#47A248',
                'skills' => [
                    ['name' => 'MongoDB', 'level' => 87, 'icon' => 'fas fa-leaf', 'color' => '#47A248'],
                    ['name' => 'MySQL / PostgreSQL', 'level' => 85, 'icon' => 'fas fa-database', 'color' => '#4479A1'],
                    ['name' => 'Firebase', 'level' => 83, 'icon' => 'fas fa-fire', 'color' => '#FFCA28'],
                    ['name' => 'Redis', 'level' => 75, 'icon' => 'fas fa-bolt', 'color' => '#DC382D'],
                ],
            ],
            [
                'title' => 'أدوات ومنصات',
                'icon' => 'fas fa-tools',
                'accent' => '#2496ED',
                'skills' => [
                    ['name' => 'Git / GitHub', 'level' => 92, 'icon' => 'fab fa-github', 'color' => '#181717'],
                    ['name' => 'Docker', 'level' => 78, 'icon' => 'fab fa-docker', 'color' => '#2496ED'],
                    ['name' => 'Linux / Shell', 'level' => 85, 'icon' => 'fab fa-linux', 'color' => '#FCC624'],
                    ['name' => 'Figma / UI Design', 'level' => 80, 'icon' => 'fab fa-figma', 'color' => '#F24E1E'],
                ],
            ],
        ];
    @endphp

    <!-- ============ مهاراتي التفصيلية ============ -->
    <section class="section-padding about-skills-section">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">مهاراتي</span>
                <h2>مهاراتي التفصيلية</h2>
                <p>لغات برمجة، أطر عمل، قواعد بيانات وأدوات أتقنها وأستخدمها في مشاريعي ودوراتي</p>
            </div>

            <div class="skills-detailed animate-on-scroll" id="aboutSkillsDetailed">
                <div class="row g-4">
                    @foreach($aboutSkillCategories as $catIndex => $category)
                    <div class="col-lg-6">
                        <div class="glass-panel skills-category" style="--cat-accent: {{ $category['accent'] }}">
                            <div class="skills-category-header">
                                <span class="skills-category-icon"><i class="{{ $category['icon'] }}"></i></span>
                                <h4 class="skills-category-title">{{ $category['title'] }}</h4>
                            </div>
                            <div class="skills-tech-list">
                                @foreach($category['skills'] as $skill)
                                <div class="skill-tech-item">
                                    <span class="skill-tech-icon" style="--tech-color: {{ $skill['color'] }}">
                                        <i class="{{ $skill['icon'] }}"></i>
                                    </span>
                                    <div class="skill-tech-body">
                                        <div class="skill-progress-head">
                                            <span class="skill-tech-name">{{ $skill['name'] }}</span>
                                            <span class="skill-progress-pct">{{ $skill['level'] }}%</span>
                                        </div>
                                        <div class="skill-progress-bar">
                                            <div
                                                class="skill-progress-fill"
                                                data-level="{{ $skill['level'] }}"
                                                style="--fill-color: {{ $skill['color'] }}"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SPECIALTIES ============ -->
    <section class="section-padding about-specialties-section" id="specialties">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">التخصصات</span>
                <h2>مجالات التخصص</h2>
                <p>المجالات التقنية التي أملك خبرة متعمقة فيها</p>
            </div>
            <div class="row g-4">
                @foreach($aboutSpecialties as $index => $specialty)
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel about-specialty-card animate-on-scroll animate-delay-{{ $index + 1 }}">
                        <div class="about-specialty-header">
                            <span class="about-specialty-icon"><i class="{{ $specialty['icon'] }}"></i></span>
                            <h5>{{ $specialty['title'] }}</h5>
                        </div>
                        <p class="about-specialty-desc">{{ $specialty['desc'] }}</p>
                        <div class="about-specialty-tags">
                            @foreach($specialty['tags'] as $tag)
                            <span class="about-tech-tag" style="--tech-color: {{ $tag['color'] }}">
                                <i class="{{ $tag['icon'] }}"></i> {{ $tag['name'] }}
                            </span>
                            @endforeach
                        </div>
                        <a href="{{ route('service.show', $specialty['route']) }}" class="about-specialty-link">
                            اعرف المزيد <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2>هل لديك مشروع أو فكرة تحتاج تنفيذها؟</h2>
            <p>دعنا نتحدث ونحول فكرتك إلى واقع ملموس</p>
            <a href="{{ route('contact') }}" class="btn-light-custom">
                <i class="fas fa-envelope"></i> تواصل معي
            </a>
        </div>
    </section>

@endsection

@section('scripts')
<script>
(function() {
    const filter = document.getElementById('journeyFilter');
    const timeline = document.getElementById('journeyTimeline');
    const emptyFiltered = document.getElementById('journeyEmptyFiltered');
    if (!filter || !timeline) return;

    const btns = filter.querySelectorAll('.journey-filter-btn');
    const items = timeline.querySelectorAll('.timeline-item');

    function applyFilter(categorySlug, updateUrl = true) {
        btns.forEach(btn => {
            btn.classList.toggle('active', (btn.dataset.category || '') === (categorySlug || ''));
        });
        let visibleCount = 0;
        items.forEach(item => {
            const itemCat = item.dataset.category || '';
            const show = !categorySlug || itemCat === categorySlug;
            item.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        if (emptyFiltered) {
            emptyFiltered.style.display = (categorySlug && visibleCount === 0) ? 'block' : 'none';
        }
        if (updateUrl) {
            const url = categorySlug ? '{{ route("about") }}?category=' + encodeURIComponent(categorySlug) : '{{ route("about") }}';
            history.pushState({ category: categorySlug || null }, '', url);
        }
    }

    btns.forEach(btn => {
        btn.addEventListener('click', function() {
            applyFilter(this.dataset.category || '');
        });
    });

    window.addEventListener('popstate', function(e) {
        applyFilter(e.state?.category || '', false);
    });

    // تطبيق التصنيف من الرابط عند التحميل
    const urlParams = new URLSearchParams(window.location.search);
    const initialCat = urlParams.get('category') || '';
    if (initialCat) applyFilter(initialCat, false);
})();

(function() {
    const skillsBlock = document.getElementById('aboutSkillsDetailed');
    if (!skillsBlock) return;

    const fills = skillsBlock.querySelectorAll('.skill-progress-fill');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reducedMotion) {
        fills.forEach(fill => {
            fill.style.width = (fill.dataset.level || '0') + '%';
        });
        return;
    }

    fills.forEach(fill => { fill.style.width = '0%'; });

    const animateBars = () => {
        fills.forEach((fill, i) => {
            const level = fill.dataset.level || '0';
            setTimeout(() => {
                fill.style.width = level + '%';
            }, 120 + i * 60);
        });
    };

    const barObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateBars();
                barObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    barObserver.observe(skillsBlock);
})();
</script>
@endsection