@extends('frontend.layouts.master')

@section('title', 'حول المدرب | ياسين جوخدار')
@section('description', 'تعرف على المدرب ياسين جوخدار - خبرة واسعة في تطوير البرمجيات والتدريب التقني.')

@section('content')
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
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="hero-image-wrapper animate-on-scroll">
                        <div class="hero-ring"></div>
                        <img src="{{ $fa }}/images/hero.png" alt="ياسين جوخدار" class="hero-img" width="350" height="350" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="animate-on-scroll">
                        <span class="section-badge" style="display:inline-block; margin-bottom:15px;">من أنا؟</span>
                        <h2 style="font-weight:800; font-size:2rem; margin-bottom:20px;">ياسين جوخدار</h2>
                        <p style="font-size:1.05rem; line-height:2; color:var(--clr-text-secondary);">
                            مدرب ومطور برمجيات سوري الجنسية، شغوف بعالم التكنولوجيا والبرمجة منذ أكثر من 10 سنوات.
                            بدأت مسيرتي في عالم تطوير الويب ثم توسعت لتشمل تطوير تطبيقات الموبايل، قواعد البيانات،
                            وأنظمة إدارة المحتوى.
                        </p>
                        <p style="font-size:1.05rem; line-height:2; color:var(--clr-text-secondary);">
                            أؤمن بأن التعليم العملي هو أفضل طريقة لاكتساب المهارات البرمجية، لذلك أركز في دوراتي
                            التدريبية على المشاريع الحقيقية
                            والتطبيق العملي. قمت بتدريب أكثر من 5000 طالب وطالبة في مختلف مجالات البرمجة.
                        </p>

                        <!-- Quick Facts -->
                        <div class="row g-3 mt-3">
                            <div class="col-sm-6">
                                <div class="glass-panel" style="padding:18px; text-align:center;">
                                    <i class="fas fa-graduation-cap"
                                        style="font-size:1.5rem; color:var(--clr-primary); margin-bottom:8px; display:block;"></i>
                                    <strong>+50 دورة تدريبية</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="glass-panel" style="padding:18px; text-align:center;">
                                    <i class="fas fa-users"
                                        style="font-size:1.5rem; color:var(--clr-primary); margin-bottom:8px; display:block;"></i>
                                    <strong>+5000 طالب</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="glass-panel" style="padding:18px; text-align:center;">
                                    <i class="fas fa-laptop-code"
                                        style="font-size:1.5rem; color:var(--clr-primary); margin-bottom:8px; display:block;"></i>
                                    <strong>+200 مشروع</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="glass-panel" style="padding:18px; text-align:center;">
                                    <i class="fas fa-certificate"
                                        style="font-size:1.5rem; color:var(--clr-primary); margin-bottom:8px; display:block;"></i>
                                    <strong>+10 شهادات معتمدة</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TIMELINE ============ -->
    <section class="section-padding" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">المسيرة المهنية</span>
                <h2>رحلتي في عالم البرمجة</h2>
                <p>محطات بارزة في مسيرتي المهنية والتعليمية</p>
            </div>

            @if($journeyCategories->isNotEmpty())
            <div class="journey-filter animate-on-scroll mb-4" id="journeyFilter">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <button type="button" class="journey-filter-btn {{ !$categorySlug ? 'active' : '' }}" data-category="">
                        الكل
                    </button>
                    @foreach($journeyCategories as $cat)
                        <button type="button" class="journey-filter-btn {{ $categorySlug === $cat->slug ? 'active' : '' }}" data-category="{{ $cat->slug }}">
                            @if($cat->icon)<i class="{{ $cat->icon }} me-1"></i>@endif
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="timeline animate-on-scroll" id="journeyTimeline">
                        @forelse($journeyMilestones as $m)
                            <div class="timeline-item" data-category="{{ $m->category->slug }}">
                                <span class="year">{{ $m->year }}</span>
                                <h5>{{ $m->title }}</h5>
                                @if($m->description)
                                    <p>{{ $m->description }}</p>
                                @endif
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

    <!-- ============ مهاراتي التفصيلية (أشرطة التقدم) ============ -->
    <section class="section-padding" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">مهاراتي</span>
                <h2>مهاراتي التفصيلية</h2>
                <p>لغات برمجة، أطر عمل، قواعد بيانات وأدوات أتقنها وأستخدمها في مشاريعي ودوراتي</p>
            </div>
            <div class="skills-detailed animate-on-scroll">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="glass-panel skills-category">
                            <h4 class="skills-category-title"><i class="fas fa-code"></i> المهارات البرمجية — اللغات</h4>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>JavaScript / TypeScript</span><span class="skill-progress-pct">92%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:92%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Python</span><span class="skill-progress-pct">88%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:88%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>HTML5 / CSS3 / SASS</span><span class="skill-progress-pct">95%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:95%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>PHP</span><span class="skill-progress-pct">80%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:80%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Dart</span><span class="skill-progress-pct">82%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:82%"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="glass-panel skills-category">
                            <h4 class="skills-category-title"><i class="fas fa-puzzle-piece"></i> أطر العمل والمكتبات</h4>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>React.js</span><span class="skill-progress-pct">90%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:90%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Node.js / Express</span><span class="skill-progress-pct">88%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:88%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Flutter</span><span class="skill-progress-pct">85%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:85%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Bootstrap / Tailwind</span><span class="skill-progress-pct">92%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:92%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Next.js / Nuxt</span><span class="skill-progress-pct">82%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:82%"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="glass-panel skills-category">
                            <h4 class="skills-category-title"><i class="fas fa-database"></i> قواعد البيانات</h4>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>MongoDB</span><span class="skill-progress-pct">87%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:87%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>MySQL / PostgreSQL</span><span class="skill-progress-pct">85%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:85%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Firebase</span><span class="skill-progress-pct">83%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:83%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Redis</span><span class="skill-progress-pct">75%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:75%"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="glass-panel skills-category">
                            <h4 class="skills-category-title"><i class="fas fa-tools"></i> أدوات ومنصات</h4>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Git / GitHub</span><span class="skill-progress-pct">92%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:92%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Docker</span><span class="skill-progress-pct">78%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:78%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Linux / Shell</span><span class="skill-progress-pct">85%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:85%"></div></div>
                            </div>
                            <div class="skill-progress-item">
                                <div class="skill-progress-head"><span>Figma / UI Design</span><span class="skill-progress-pct">80%</span></div>
                                <div class="skill-progress-bar"><div class="skill-progress-fill" style="width:80%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SKILLS DETAILED ============ -->
    <section class="section-padding" id="specialties">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">التخصصات</span>
                <h2>مجالات التخصص</h2>
                <p>المجالات التقنية التي أملك خبرة متعمقة فيها</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel animate-on-scroll animate-delay-1" style="padding:30px; height:100%;">
                        <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
                            <div
                                style="width:55px; height:55px; border-radius:var(--radius-md); background:linear-gradient(135deg, var(--clr-primary), var(--clr-primary-dark)); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem; flex-shrink:0;">
                                <i class="fas fa-code"></i></div>
                            <h5 style="font-weight:700; margin:0;">تطوير الواجهات الأمامية</h5>
                        </div>
                        <p style="color:var(--clr-text-secondary); font-size:0.95rem;">
                            بناء واجهات مستخدم تفاعلية وجذابة باستخدام HTML5, CSS3, JavaScript, React.js, Vue.js و
                            Next.js مع التركيز على التجاوب وتجربة المستخدم.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:15px;">
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">React</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Vue.js</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Next.js</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Bootstrap</span>
                        </div>
                        <a href="{{ route('service.show', 'web') }}" class="btn-outline-custom mt-3" style="display:inline-flex; padding:8px 18px; font-size:0.88rem;"><i class="fas fa-arrow-left"></i> اعرف المزيد</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel animate-on-scroll animate-delay-2" style="padding:30px; height:100%;">
                        <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
                            <div
                                style="width:55px; height:55px; border-radius:var(--radius-md); background:linear-gradient(135deg, var(--clr-primary), var(--clr-primary-dark)); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem; flex-shrink:0;">
                                <i class="fas fa-server"></i></div>
                            <h5 style="font-weight:700; margin:0;">تطوير الخوادم وAPI</h5>
                        </div>
                        <p style="color:var(--clr-text-secondary); font-size:0.95rem;">
                            تصميم وبناء خوادم وواجهات برمجة التطبيقات RESTful APIs باستخدام Node.js, Express, NestJS,
                            Python Django, وقواعد بيانات متنوعة.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:15px;">
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Node.js</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">NestJS</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Django</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">MySQL</span>
                        </div>
                        <a href="{{ route('service.show', 'servers') }}" class="btn-outline-custom mt-3" style="display:inline-flex; padding:8px 18px; font-size:0.88rem;"><i class="fas fa-arrow-left"></i> اعرف المزيد</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel animate-on-scroll animate-delay-3" style="padding:30px; height:100%;">
                        <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
                            <div
                                style="width:55px; height:55px; border-radius:var(--radius-md); background:linear-gradient(135deg, var(--clr-primary), var(--clr-primary-dark)); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.4rem; flex-shrink:0;">
                                <i class="fas fa-mobile-alt"></i></div>
                            <h5 style="font-weight:700; margin:0;">تطوير تطبيقات الموبايل</h5>
                        </div>
                        <p style="color:var(--clr-text-secondary); font-size:0.95rem;">
                            تطوير تطبيقات موبايل متعددة المنصات لنظامي Android و iOS باستخدام Flutter و React Native مع
                            واجهات مستخدم احترافية.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:15px;">
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Flutter</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">React
                                Native</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Dart</span>
                            <span
                                style="background:var(--clr-surface); padding:4px 12px; border-radius:50px; font-size:0.78rem; color:var(--clr-text-secondary);">Firebase</span>
                        </div>
                        <a href="{{ route('service.show', 'mobile') }}" class="btn-outline-custom mt-3" style="display:inline-flex; padding:8px 18px; font-size:0.88rem;"><i class="fas fa-arrow-left"></i> اعرف المزيد</a>
                    </div>
                </div>
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
</script>
@endsection