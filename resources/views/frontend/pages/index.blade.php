@extends('frontend.layouts.master')

@section('title', 'ياسين جوخدار | مدرب ومطور برمجيات')

@section('content')
    <!-- ============ HERO SECTION ============ -->
    <section class="hero-section" id="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="hero-content animate-on-scroll">
                        <h1>
                            مرحباً، أنا <span id="typingText"
                                data-texts="ياسين جوخدار|مطور ويب|مدرب تقني|صانع محتوى">ياسين جوخدار</span>
                            <span class="blinking-cursor"
                                style="animation: blink 0.8s infinite; color: var(--clr-primary);">|</span>
                        </h1>
                        <p class="subtitle">
                            مدرب ومطور برمجيات متخصص في تطوير تطبيقات الويب والموبايل. أساعد المبتدئين والمحترفين على
                            تطوير مهاراتهم البرمجية من خلال دورات تدريبية عملية ومحتوى تعليمي متميز.
                        </p>
                        <div class="hero-btns">
                            <a href="{{ route('courses') }}" class="btn-primary-custom">
                                <i class="fas fa-graduation-cap"></i> تصفّح الكورسات
                            </a>
                            <a href="{{ route('contact') }}" class="btn-outline-custom">
                                <i class="fas fa-paper-plane"></i> تواصل معي
                            </a>
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat-item">
                                <span class="stat-num counter-num" data-count="50">0+</span>
                                <span class="stat-label">دورة تدريبية</span>
                            </div>
                            <div class="hero-stat-item">
                                <span class="stat-num counter-num" data-count="5000">0+</span>
                                <span class="stat-label">طالب</span>
                            </div>
                            <div class="hero-stat-item">
                                <span class="stat-num counter-num" data-count="10">0+</span>
                                <span class="stat-label">سنوات خبرة</span>
                            </div>
                            <div class="hero-stat-item">
                                <span class="stat-num counter-num" data-count="200">0+</span>
                                <span class="stat-label">مشروع منجز</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2">
                    <div class="hero-image-wrapper animate-on-scroll">
                        <div class="hero-ring"></div>
                        <img src="{{ $fa }}/images/hero.png" alt="ياسين جوخدار" class="hero-img" width="350" height="350" loading="eager">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SKILLS SECTION ============ -->
    <section class="section-padding" id="skills">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">مهاراتي</span>
                <h2>المهارات والاختصاصات</h2>
                <p>خبرة في مجالات تقنية متعددة من التطوير والإدارة إلى الأمن والاستشارات</p>
            </div>
            <div class="row g-4">
                <!-- Skill 1 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'web') }}" class="glass-panel skill-card animate-on-scroll animate-delay-1" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-globe"></i></div>
                        <h5>تطوير تطبيقات الويب</h5>
                        <p>تصميم وتطوير مواقع وتطبيقات ويب حديثة ومتجاوبة واحترافية</p>
                    </a>
                </div>
                <!-- Skill 2 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'mobile') }}" class="glass-panel skill-card animate-on-scroll animate-delay-2" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-mobile-alt"></i></div>
                        <h5>تطبيقات الجوال</h5>
                        <p>تطوير تطبيقات الهواتف الذكية متعددة المنصات للأندرويد والـ iOS</p>
                    </a>
                </div>
                <!-- Skill 3 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'security') }}" class="glass-panel skill-card animate-on-scroll animate-delay-3" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-shield-alt"></i></div>
                        <h5>أمن المعلومات</h5>
                        <p>حماية الأنظمة والبيانات وتقييم الثغرات وتطبيق أفضل الممارسات الأمنية</p>
                    </a>
                </div>
                <!-- Skill 4 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'servers') }}" class="glass-panel skill-card animate-on-scroll animate-delay-4" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-server"></i></div>
                        <h5>إدارة السيرفرات</h5>
                        <p>إعداد وإدارة الخوادم، الاستضافة، والنشر مع Linux والخدمات السحابية</p>
                    </a>
                </div>
                <!-- Skill 5 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'web') }}" class="glass-panel skill-card animate-on-scroll animate-delay-1" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-database"></i></div>
                        <h5>قواعد البيانات</h5>
                        <p>تصميم وإدارة قواعد البيانات SQL و NoSQL وتحسين الأداء</p>
                    </a>
                </div>
                <!-- Skill 6 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'devops') }}" class="glass-panel skill-card animate-on-scroll animate-delay-2" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-cloud"></i></div>
                        <h5>DevOps والسحابة</h5>
                        <p>أتمتة النشر، الحاويات، CI/CD والعمل على منصات سحابية</p>
                    </a>
                </div>
                <!-- Skill 7 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'web') }}" class="glass-panel skill-card animate-on-scroll animate-delay-3" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-project-diagram"></i></div>
                        <h5>إدارة المشاريع التقنية</h5>
                        <p>تخطيط ومتابعة المشاريع البرمجية وتنسيق الفرق التقنية</p>
                    </a>
                </div>
                <!-- Skill 8 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('service.show', 'web') }}" class="glass-panel skill-card animate-on-scroll animate-delay-4" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="skill-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h5>استشارات وتدريب تقني</h5>
                        <p>تقديم الاستشارات التقنية ودورات تدريبية في البرمجة والتكنولوجيا</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FEATURED COURSES ============ -->
    <section class="section-padding" id="courses" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">الكورسات</span>
                <h2>أحدث الدورات التدريبية</h2>
                <p>دورات عملية شاملة تأخذك من الصفر إلى الاحتراف</p>
            </div>
            <div class="row g-4">
                @forelse($courses ?? [] as $course)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('course.show', $course->slug) }}" class="glass-panel course-card animate-on-scroll animate-delay-{{ $loop->iteration }}"
                        style="text-decoration:none;color:inherit;cursor:pointer;display:block;">
                        <div class="course-img-wrapper">
                            <img src="{{ $course->image ? route('course.image', ['filename' => basename($course->image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $course->title }}" width="400" height="200" loading="lazy">
                            @if($course->badge)
                            <span class="course-badge">{{ $course->badge }}</span>
                            @endif
                        </div>
                        <div class="course-body">
                            <h5>{{ $course->title }}</h5>
                            <p>{{ $course->short_description ?? Str::limit($course->description ?? '', 100) }}</p>
                        </div>
                        <div class="course-footer">
                            <span><i class="fas fa-users"></i> {{ number_format($course->students_count) }} طالب</span>
                            <span><i class="fas fa-clock"></i> {{ $course->duration_hours ? $course->duration_hours . ' ساعة' : '-' }}</span>
                            <span class="price">${{ number_format($course->price, 2) }}</span>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">لا توجد دورات لعرضها حالياً.</p>
                    <a href="{{ route('courses') }}" class="btn-primary-custom mt-2"><i class="fas fa-th-list"></i> تصفّح الكورسات</a>
                </div>
                @endforelse
            </div>
            @if(isset($courses) && $courses->count() > 0)
            <div class="text-center mt-5 animate-on-scroll">
                <a href="{{ route('courses') }}" class="btn-primary-custom">
                    <i class="fas fa-th-list"></i> عرض جميع الكورسات
                </a>
            </div>
            @endif
        </div>
    </section>

    @if(isset($testimonials) && $testimonials->count())
        <!-- ============ TESTIMONIALS ============ -->
        <section class="section-padding" id="testimonials">
            <div class="container">
                <div class="section-header animate-on-scroll">
                    <span class="section-badge">آراء الطلاب</span>
                    <h2>ماذا يقول طلابنا</h2>
                    <p>آراء وتجارب بعض الطلاب الذين استفادوا من دوراتنا التدريبية</p>
                </div>
                <div class="row g-4">
                    @foreach($testimonials as $testimonial)
                        <div class="col-lg-4 col-md-6">
                            <div class="glass-panel testimonial-card animate-on-scroll animate-delay-{{ $loop->iteration }}">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5 animate-on-scroll">
                    <a href="{{ route('testimonials') }}" class="btn-primary-custom">
                        <i class="fas fa-comments"></i> عرض كل آراء الطلاب
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- ============ GALLERY SECTION ============ -->
    <section class="section-padding" id="gallery" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">معرض الصور</span>
                <h2>صور من نشاطاتي</h2>
                <p>لقطات من الفعاليات والورشات والدورات التدريبية</p>
            </div>
            <div class="gallery-grid animate-on-scroll">
                @forelse($galleryImages ?? collect([]) as $item)
                <div class="gallery-item">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" width="400" height="250" loading="lazy">
                    <div class="gallery-overlay">
                        <span class="gallery-caption">{{ $item->title }}</span>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted mb-0">لا توجد صور في المعرض حالياً.</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-5 animate-on-scroll">
                <a href="{{ route('gallery') }}" class="btn-primary-custom">
                    <i class="fas fa-images"></i> عرض المعرض
                </a>
            </div>
        </div>
    </section>

    <!-- ============ VIDEOS SECTION ============ -->
    <section class="section-padding" id="videos">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">الفيديوهات</span>
                <h2>فيديوهات من أعمالي</h2>
                <p>مقاطع فيديو تعليمية وعملية من القناة</p>
            </div>
            <div class="row g-4">
                @forelse($videos ?? collect([]) as $video)
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
                <div class="col-12 text-center py-4">
                    <p class="text-muted mb-0">لا توجد فيديوهات مميزة حالياً.</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-5 animate-on-scroll">
                <a href="{{ route('videos') }}" class="btn-primary-custom">
                    <i class="fas fa-play-circle"></i> عرض كل الفيديوهات
                </a>
            </div>
        </div>
    </section>

    <!-- ============ BLOG SECTION ============ -->
    <section class="section-padding" id="blog" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">المدونة</span>
                <h2>آخر التدوينات</h2>
                <p>مقالات تقنية وتعليمية في عالم البرمجة والتكنولوجيا</p>
            </div>
            <div class="row g-4">
                @forelse($blogPosts as $post)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-link" style="text-decoration:none;color:inherit;display:block;height:100%;">
                        <div class="glass-panel blog-card animate-on-scroll animate-delay-{{ $loop->iteration }}">
                            <div class="blog-img-wrapper">
                                <img src="{{ $post->featured_image ? route('blog.image', ['filename' => basename($post->featured_image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $post->featured_image_alt ?? $post->title }}" width="400" height="180" loading="lazy">
                            </div>
                            <div class="blog-body">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> {{ $post->published_at?->translatedFormat('d F Y') }}</span>
                                    <span><i class="fas fa-tag"></i> {{ $post->category?->name ?? '—' }}</span>
                                </div>
                                <h5>{{ $post->title }}</h5>
                                <p>{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 80) }}</p>
                                <span class="read-more">اقرأ المزيد <i class="fas fa-arrow-left"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">لا توجد تدوينات حالياً.</p>
                    <a href="{{ route('blog') }}" class="btn-primary-custom mt-2">تصفّح المدونة</a>
                </div>
                @endforelse
            </div>
            @if(isset($blogPosts) && $blogPosts->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('blog') }}" class="btn-outline-custom">عرض كل التدوينات <i class="fas fa-arrow-left"></i></a>
            </div>
            @endif
        </div>
    </section>

    <!-- ============ CLIENTS PREVIEW ============ -->
    <section class="section-padding" id="clients-preview" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">ثقة غالية</span>
                <h2>شركاؤنا والعملاء</h2>
                <p>شكراً لكل من وثق بي — تعرف على بعض الشركات والعملاء الذين تعاملت معهم</p>
            </div>
            <div class="row g-4">
                @forelse($partners ?? collect([]) as $partner)
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel client-card animate-on-scroll">
                        <div class="client-card-logo">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" width="80" height="80" loading="lazy">
                        </div>
                        <span class="client-card-type">{{ \App\Models\Partner::typeLabel($partner->type) }}</span>
                        <h3 class="client-card-name">{{ $partner->name }}</h3>
                        @if($partner->description)
                        <p class="client-card-desc">{{ Str::limit($partner->description, 120) }}</p>
                        @endif
                        @if($partner->quote)
                        <blockquote class="client-card-quote">"{{ $partner->quote }}"</blockquote>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted mb-0">لا يوجد شركاء أو عملاء مميزون حالياً.</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-5 animate-on-scroll">
                <a href="{{ route('clients') }}" class="btn-primary-custom">
                    <i class="fas fa-handshake"></i> تعرف على كل الشركات والعملاء
                </a>
            </div>
        </div>
    </section>

    <!-- ============ NEWSLETTER SECTION ============ -->
    <section class="section-padding newsletter-home-section" id="newsletter">
        <div class="container">
            <div class="newsletter-home-card glass-panel animate-on-scroll">
                <div class="newsletter-home-benefits">
                    <div class="newsletter-benefit-item">
                        <div class="newsletter-benefit-icon"><i class="fas fa-lightbulb"></i></div>
                        <span>نصائح تقنية</span>
                    </div>
                    <div class="newsletter-benefit-item">
                        <div class="newsletter-benefit-icon"><i class="fas fa-gift"></i></div>
                        <span>عروض خاصة</span>
                    </div>
                    <div class="newsletter-benefit-item">
                        <div class="newsletter-benefit-icon"><i class="fas fa-bell"></i></div>
                        <span>أخبار فورية</span>
                    </div>
                    <div class="newsletter-benefit-item">
                        <div class="newsletter-benefit-icon"><i class="fas fa-envelope"></i></div>
                        <span>رسائل حصرية</span>
                    </div>
                </div>
                <h2 class="newsletter-home-title">
                    <i class="fas fa-paper-plane"></i> اشترك في نشرتنا البريدية
                </h2>
                <p class="newsletter-home-desc">احصل على آخر المقالات، العروض، وأخبار الدورات مباشرة في بريدك</p>
                <div class="newsletter-home-form-wrap">
                    @include('frontend.partials.newsletter-form', ['source' => 'home', 'variant' => 'home'])
                </div>
                <p class="newsletter-home-privacy">
                    <i class="fas fa-shield-alt"></i> تحترم خصوصيتك ولا نشارك بريدك مع أي جهة
                </p>
            </div>
        </div>
    </section>

    <!-- ============ CTA SECTION ============ -->
    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2>هل أنت مستعد لبدء رحلتك البرمجية؟</h2>
            <p>انضم لأكثر من 5000 طالب وابدأ رحلتك في عالم البرمجة اليوم</p>
            <a href="{{ route('courses') }}" class="btn-light-custom">
                <i class="fas fa-rocket"></i> ابدأ الآن
            </a>
        </div>
    </section>
@endsection
