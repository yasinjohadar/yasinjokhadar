@extends('frontend.layouts.master')

@section('title', ($course->meta_title ?? $course->title) . ' | ياسين جوخدار')
@section('description', $course->meta_description ?? $course->short_description ?? Str::limit(strip_tags($course->description ?? ''), 160))

@section('content')
    <!-- COURSE HERO -->
    <section class="course-detail-hero">
        <div class="container">
            <div class="animate-on-scroll">
                <nav class="breadcrumb-custom cd-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span>/</span>
                    <a href="{{ route('courses') }}">الكورسات</a>
                    <span>/</span>
                    <span>{{ $course->category->name ?? 'دورة' }}</span>
                </nav>

                @if($course->badge)
                <div class="cd-hero-badge-row">
                    <span class="cd-tag"><i class="fas fa-fire"></i> {{ $course->badge }}</span>
                </div>
                @endif

                <h1 class="cd-title">{{ $course->title }}</h1>
                <p class="cd-subtitle">{{ $course->short_description ?? Str::limit(strip_tags($course->description ?? ''), 200) }}</p>

                <div class="cd-meta-row">
                    <div class="cd-meta-item"><i class="fas fa-users"></i> {{ number_format($course->students_count) }} طالب</div>
                    <div class="cd-meta-item"><i class="fas fa-clock"></i> {{ $course->duration_hours ? $course->duration_hours . ' ساعة' : '-' }}</div>
                    <div class="cd-meta-item"><i class="fas fa-play-circle"></i> {{ $course->lessons_count ? $course->lessons_count . ' درس' : '-' }}</div>
                    @if($course->level)<div class="cd-meta-item"><i class="fas fa-signal"></i> {{ $course->level }}</div>@endif
                    @if($course->language)<div class="cd-meta-item"><i class="fas fa-language"></i> {{ $course->language }}</div>@endif
                </div>

                <div class="cd-instructor-mini">
                    <img src="{{ $fa }}/images/logo.svg" alt="المدرب">
                    <div>
                        <span class="cd-instructor-name">المدرب ياسين جوخدار</span>
                        <span class="cd-instructor-role">مطور ومدرب تقني | +10 سنوات خبرة</span>
                    </div>
                </div>

                @php $highlights = $course->highlights_items; @endphp
                @if(!empty($highlights))
                <div class="cd-hero-highlights glass-panel">
                    <h4 class="cd-hero-highlights-title"><i class="fas fa-bolt"></i> لمحة سريعة عن الدورة</h4>
                    <div class="cd-hero-highlights-grid">
                        @foreach($highlights as $item)
                            <span class="cd-hero-highlight-item"><i class="fas fa-check-circle"></i> {{ $item }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- COURSE BODY -->
    <section class="section-padding course-detail-body">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8 order-2 order-lg-1">
                    @if($course->description)
                    <div class="glass-panel animate-on-scroll cd-section-card">
                        <h3 class="cd-section-title"><i class="fas fa-align-right"></i> وصف الدورة</h3>
                        <div class="course-description-content">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>
                    @endif

                    @php $learnItems = $course->learn_items_items; @endphp
                    @if(!empty($learnItems))
                    <div class="glass-panel animate-on-scroll cd-section-card">
                        <h3 class="cd-section-title"><i class="fas fa-lightbulb"></i> ماذا ستتعلم في هذه الدورة</h3>
                        @php
                            $totalLearn = count($learnItems);
                            $half = (int) ceil($totalLearn / 2);
                            $learnCol1 = array_slice($learnItems, 0, $half);
                            $learnCol2 = array_slice($learnItems, $half);
                        @endphp
                        <div class="row g-3">
                            <div class="col-md-6">
                                @foreach($learnCol1 as $item)
                                    <div class="cd-learn-item"><i class="fas fa-check-circle"></i> {{ $item }}</div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @foreach($learnCol2 as $item)
                                    <div class="cd-learn-item"><i class="fas fa-check-circle"></i> {{ $item }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @php $requirements = $course->requirements_items; @endphp
                    @if(!empty($requirements))
                    <div class="glass-panel animate-on-scroll cd-section-card">
                        <h3 class="cd-section-title"><i class="fas fa-clipboard-list"></i> المتطلبات المسبقة</h3>
                        <ul class="cd-req-list">
                            @foreach($requirements as $item)
                                <li><i class="fas fa-arrow-left"></i> {{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="glass-panel animate-on-scroll cd-section-card">
                        <div class="cd-section-head">
                            <h3 class="cd-section-title cd-section-title--inline"><i class="fas fa-list-ol"></i> محتوى الدورة</h3>
                            @php
                                $sectionsCount = $course->sections->count();
                                $lessonsCount = $course->sections->flatMap->lessons->count();
                            @endphp
                            <span class="cd-section-meta">{{ $sectionsCount }} قسم • {{ $lessonsCount }} درس</span>
                        </div>
                        @if($sectionsCount > 0)
                        <div class="accordion" id="curriculumAccordion">
                            @foreach($course->sections as $index => $section)
                            @php
                                $sectionId = 'section_' . $section->id;
                                $open = $index === 0 ? 'show' : '';
                            @endphp
                            <div class="cd-module">
                                <button class="cd-module-header {{ $open ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $sectionId }}">
                                    <div class="cd-module-title">
                                        <i class="fas fa-chevron-down cd-chevron"></i>
                                        <span>{{ $section->title }}</span>
                                    </div>
                                    <div class="cd-module-info">
                                        {{ $section->lessons->count() }} درس
                                    </div>
                                </button>
                                <div class="collapse {{ $open }}" id="{{ $sectionId }}" data-bs-parent="#curriculumAccordion">
                                    <div class="cd-module-body">
                                        @forelse($section->lessons as $lesson)
                                        <div class="cd-lesson">
                                            <i class="fas fa-play-circle cd-lesson-icon"></i>
                                            <span>{{ $lesson->title }}</span>
                                            <span class="cd-lesson-dur">
                                                @if($lesson->is_preview)
                                                    <i class="fas fa-unlock cd-lesson-unlock"></i>
                                                @else
                                                    <i class="fas fa-lock cd-lesson-lock"></i>
                                                @endif
                                                @if($lesson->duration_minutes)
                                                    {{ $lesson->duration_minutes }} دقيقة
                                                @endif
                                            </span>
                                        </div>
                                        @empty
                                        <p class="text-muted mb-0">لا توجد دروس في هذا القسم حالياً.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted mb-0">لم تتم إضافة محتوى لهذه الدورة بعد.</p>
                        @endif
                    </div>

                    <div class="glass-panel animate-on-scroll cd-section-card">
                        <h3 class="cd-section-title"><i class="fas fa-star"></i> تقييمات الطلاب</h3>
                        <div class="cd-rating-overview">
                            <div class="cd-rating-big">
                                <span class="cd-rating-num">4.9</span>
                                <div class="cd-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span class="cd-rating-count">342 تقييم</span>
                            </div>
                            <div class="cd-rating-bars">
                                <div class="cd-bar-row"><span>5 <i class="fas fa-star cd-star-sm"></i></span><div class="cd-bar"><div class="cd-bar-fill" style="width:85%;"></div></div><span>85%</span></div>
                                <div class="cd-bar-row"><span>4 <i class="fas fa-star cd-star-sm"></i></span><div class="cd-bar"><div class="cd-bar-fill" style="width:10%;"></div></div><span>10%</span></div>
                                <div class="cd-bar-row"><span>3 <i class="fas fa-star cd-star-sm"></i></span><div class="cd-bar"><div class="cd-bar-fill" style="width:3%;"></div></div><span>3%</span></div>
                                <div class="cd-bar-row"><span>2 <i class="fas fa-star cd-star-sm"></i></span><div class="cd-bar"><div class="cd-bar-fill" style="width:1%;"></div></div><span>1%</span></div>
                                <div class="cd-bar-row"><span>1 <i class="fas fa-star cd-star-sm"></i></span><div class="cd-bar"><div class="cd-bar-fill" style="width:1%;"></div></div><span>1%</span></div>
                            </div>
                        </div>
                        <div class="cd-review">
                            <div class="cd-review-head">
                                <div class="cd-review-user">
                                    <div class="cd-review-avatar cd-review-avatar--primary">أ</div>
                                    <div>
                                        <strong>أحمد محمد</strong>
                                        <span class="cd-review-date">منذ أسبوعين</span>
                                    </div>
                                </div>
                                <div class="cd-stars cd-stars--sm"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            </div>
                            <p class="cd-review-text">أفضل دورة ويب باللغة العربية! الشرح واضح جداً والتطبيقات العملية ممتازة. استفدت كثيراً وبدأت أعمل كمطور ويب مستقل.</p>
                        </div>
                        <div class="cd-review">
                            <div class="cd-review-head">
                                <div class="cd-review-user">
                                    <div class="cd-review-avatar cd-review-avatar--purple">س</div>
                                    <div>
                                        <strong>سارة العلي</strong>
                                        <span class="cd-review-date">منذ شهر</span>
                                    </div>
                                </div>
                                <div class="cd-stars cd-stars--sm"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            </div>
                            <p class="cd-review-text">دورة شاملة ومتكاملة. المدرب ياسين يشرح بأسلوب سلس وبسيط. المشاريع العملية هي أكثر ما أعجبني في الدورة.</p>
                        </div>
                    </div>
                </div>

                <!-- UNIFIED SIDEBAR -->
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="cd-sidebar">
                        <div class="cd-preview-card glass-panel animate-on-scroll">
                            <div class="cd-preview-img">
                                <img src="{{ $course->image ? route('course.image', ['filename' => basename($course->image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $course->title }}">
                            </div>
                            <div class="cd-preview-body">
                                <div class="cd-price-row">
                                    <span class="cd-price">${{ number_format($course->price, 2) }}</span>
                                    @if($course->old_price && $course->old_price > $course->price)
                                    <span class="cd-old-price">${{ number_format($course->old_price, 2) }}</span>
                                    @php $pct = round((($course->old_price - $course->price) / $course->old_price) * 100); @endphp
                                    <span class="cd-discount">خصم {{ $pct }}%</span>
                                    @endif
                                </div>
                                <p class="cd-offer-note"><i class="fas fa-bolt"></i> ينتهي العرض خلال يومين!</p>
                                <a href="{{ route('contact') }}" class="btn-primary-custom w-100 cd-btn-register">
                                    <i class="fas fa-shopping-cart"></i> سجّل الآن
                                </a>
                                <a href="#" class="btn-outline-custom w-100 cd-btn-favorite">
                                    <i class="fas fa-heart"></i> أضف للمفضلة
                                </a>
                                <div class="cd-includes">
                                    <h6><i class="fas fa-gift"></i> تشمل الدورة:</h6>
                                    <ul>
                                        @if($course->duration_hours)<li><i class="fas fa-check"></i> {{ $course->duration_hours }} ساعة فيديو</li>@endif
                                        @if($course->lessons_count)<li><i class="fas fa-check"></i> {{ $course->lessons_count }} درس تطبيقي</li>@endif
                                        <li><i class="fas fa-check"></i> ملفات المصدر</li>
                                        <li><i class="fas fa-check"></i> شهادة إتمام</li>
                                        <li><i class="fas fa-check"></i> وصول مدى الحياة</li>
                                        <li><i class="fas fa-check"></i> دعم فني</li>
                                    </ul>
                                </div>
                                <div class="cd-preview-footer">
                                    <a href="#"><i class="fas fa-share-alt"></i> مشاركة</a>
                                    <a href="#"><i class="fas fa-gift"></i> إهداء</a>
                                </div>
                            </div>
                        </div>

                        <div class="glass-panel animate-on-scroll cd-section-card cd-instructor-card">
                            <img src="{{ $fa }}/images/trainer.svg" alt="المدرب" class="cd-instructor-avatar">
                            <h5 class="cd-instructor-card-name">ياسين جوخدار</h5>
                            <p class="cd-instructor-card-title">مطور ويب ومدرب تقني</p>
                            <p class="cd-instructor-card-bio">مدرب ومطور برمجيات بخبرة +10 سنوات في تطوير الويب والموبايل والتدريب التقني.</p>
                            <div class="cd-instructor-stats">
                                <div><span class="cd-instructor-stat-num">4.9</span><span class="cd-instructor-stat-label">التقييم</span></div>
                                <div><span class="cd-instructor-stat-num">5,000+</span><span class="cd-instructor-stat-label">طالب</span></div>
                                <div><span class="cd-instructor-stat-num">50+</span><span class="cd-instructor-stat-label">دورة</span></div>
                            </div>
                            <a href="{{ route('about') }}" class="btn-outline-custom cd-btn-profile">
                                <i class="fas fa-user"></i> عرض الملف الشخصي
                            </a>
                        </div>

                        <div class="glass-panel animate-on-scroll cd-section-card">
                            <h5 class="cd-related-title"><i class="fas fa-book"></i> دورات مشابهة</h5>
                            @forelse($relatedCourses as $related)
                            <a href="{{ route('course.show', $related->slug) }}" class="cd-related-course text-decoration-none d-block">
                                <img src="{{ $related->image ? route('course.image', ['filename' => basename($related->image)]) : $fa . '/images/course-webdev.svg' }}" alt="{{ $related->title }}">
                                <div>
                                    <h6 class="cd-related-name">{{ Str::limit($related->title, 30) }}</h6>
                                    <span class="cd-related-price">${{ number_format($related->price, 2) }}</span>
                                </div>
                            </a>
                            @empty
                            <p class="text-muted small">لا توجد دورات مشابهة حالياً.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2>هل أنت مستعد لبدء رحلتك؟</h2>
            <p>سجّل الآن واحصل على الدورة</p>
            <a href="{{ route('contact') }}" class="btn-light-custom"><i class="fas fa-rocket"></i> سجّل الآن بـ ${{ number_format($course->price, 2) }}</a>
        </div>
    </section>
@endsection
