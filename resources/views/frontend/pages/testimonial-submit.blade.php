@extends('frontend.layouts.master')

@section('title', 'شاركنا رأيك | ياسين جوخدار')
@section('description', 'شاركنا تجربتك مع دورات ياسين جوخدار التدريبية — رأيك يهمنا ويُراجع قبل النشر.')

@section('content')
    <section class="page-banner page-banner-testimonials">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-pen-fancy"></i></div>
                <h1 class="page-banner-title">شاركنا <span>رأيك</span></h1>
                <p class="page-banner-desc">ساعد الطلاب الآخرين بمشاركة تجربتك الحقيقية مع دوراتنا التدريبية</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <a href="{{ route('testimonials') }}">آراء الطلاب</a>
                    <span class="page-banner-sep">/</span>
                    <span>شاركنا رأيك</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <section class="section-padding testimonial-submit-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section-header text-center animate-on-scroll">
                        <span class="section-badge">تجربتك تهمنا</span>
                        <h2>أخبرنا عن تجربتك</h2>
                        <p>املأ النموذج أدناه — سيُراجع رأيك من الإدارة قبل ظهوره في صفحة آراء الطلاب</p>
                    </div>

                    <div class="glass-panel contact-form-card testimonial-submit-card animate-on-scroll">
                        <div class="contact-form-header">
                            <span class="contact-form-header-icon"><i class="fas fa-star"></i></span>
                            <div>
                                <h2>نموذج إرسال الرأي</h2>
                                <p>جميع الحقول المميزة بـ <span class="text-danger">*</span> إلزامية</p>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="contact-alert contact-alert--success" role="alert">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="contact-alert contact-alert--error" role="alert">
                                <i class="fas fa-exclamation-circle"></i>
                                <div>
                                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form class="contact-form testimonial-submit-form" action="{{ route('testimonials.submit.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="contact-field-label" for="studentName">
                                        <i class="fas fa-user"></i> الاسم الكامل <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="studentName" name="student_name" class="contact-field @error('student_name') is-invalid @enderror" placeholder="أدخل اسمك" value="{{ old('student_name') }}" required>
                                    @error('student_name')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="contact-field-label" for="studentEmail">
                                        <i class="fas fa-envelope"></i> البريد الإلكتروني
                                    </label>
                                    <input type="email" id="studentEmail" name="student_email" class="contact-field @error('student_email') is-invalid @enderror" placeholder="example@email.com" value="{{ old('student_email') }}">
                                    @error('student_email')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="contact-field-label" for="studentTitle">
                                        <i class="fas fa-briefcase"></i> المسمى الوظيفي / التخصص
                                    </label>
                                    <input type="text" id="studentTitle" name="student_title" class="contact-field @error('student_title') is-invalid @enderror" placeholder="مثال: مطوّر ويب، طالب جامعي..." value="{{ old('student_title') }}">
                                    @error('student_title')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="contact-field-label" for="courseName">
                                        <i class="fas fa-graduation-cap"></i> الدورة التدريبية <span class="text-danger">*</span>
                                    </label>
                                    <select id="courseName" name="course_name" class="contact-field contact-field--select @error('course_name') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('course_name') ? '' : 'selected' }}>اختر الدورة</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->title }}" {{ old('course_name') === $course->title ? 'selected' : '' }}>{{ $course->title }}</option>
                                        @endforeach
                                        <option value="other" {{ old('course_name') === 'other' ? 'selected' : '' }}>دورة أخرى</option>
                                    </select>
                                    @error('course_name')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 {{ old('course_name') === 'other' ? '' : 'd-none' }}" id="courseOtherWrap">
                                    <label class="contact-field-label" for="courseOther">
                                        <i class="fas fa-book"></i> اسم الدورة <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="courseOther" name="course_other" class="contact-field @error('course_other') is-invalid @enderror" placeholder="اكتب اسم الدورة" value="{{ old('course_other') }}">
                                    @error('course_other')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="contact-field-label">
                                        <i class="fas fa-star"></i> التقييم <span class="text-danger">*</span>
                                    </label>
                                    <div class="testimonial-star-rating @error('rating') is-invalid @enderror" id="starRating" role="radiogroup" aria-label="التقييم">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ (int) old('rating', 0) === $i ? 'checked' : '' }} required>
                                            <label for="rating{{ $i }}" title="{{ $i }} نجوم"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                    <p class="testimonial-rating-hint" id="ratingHint">اختر عدد النجوم من 1 إلى 5</p>
                                    @error('rating')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="contact-field-label" for="quote">
                                        <i class="fas fa-quote-right"></i> رأيك وتجربتك <span class="text-danger">*</span>
                                    </label>
                                    <textarea id="quote" name="quote" class="contact-field contact-field--textarea @error('quote') is-invalid @enderror" rows="6" placeholder="شاركنا تجربتك مع الدورة: ماذا استفدت؟ كيف ساعدتك؟ (20 حرفاً على الأقل)" required minlength="20" maxlength="2000">{{ old('quote') }}</textarea>
                                    <div class="testimonial-char-count"><span id="quoteCount">0</span> / 2000</div>
                                    @error('quote')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="contact-field-label" for="avatar">
                                        <i class="fas fa-camera"></i> صورة شخصية (اختياري)
                                    </label>
                                    <div class="testimonial-avatar-upload">
                                        <label class="testimonial-avatar-dropzone" for="avatar">
                                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/webp" class="testimonial-avatar-input @error('avatar') is-invalid @enderror">
                                            <span class="testimonial-avatar-dropzone-icon"><i class="fas fa-cloud-upload-alt"></i></span>
                                            <span class="testimonial-avatar-dropzone-text">اسحب الصورة أو انقر للاختيار</span>
                                            <small>JPG, PNG, WEBP — بحد أقصى 2 ميجابايت</small>
                                        </label>
                                        <div class="testimonial-avatar-preview d-none" id="avatarPreview">
                                            <img src="" alt="معاينة الصورة" id="avatarPreviewImg">
                                            <button type="button" class="testimonial-avatar-remove" id="avatarRemove" aria-label="إزالة الصورة">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('avatar')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="testimonial-consent @error('consent') is-invalid @enderror">
                                        <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }} required>
                                        <span>أوافق على مراجعة رأيي من الإدارة قبل نشره في الموقع، وأتعهد بأن المحتوى صحيح ويعكس تجربتي الحقيقية.</span>
                                    </label>
                                    @error('consent')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12 d-flex flex-wrap gap-3 align-items-center">
                                    <button type="submit" class="btn-primary-custom contact-submit-btn">
                                        <i class="fas fa-paper-plane"></i> إرسال الرأي
                                    </button>
                                    <a href="{{ route('testimonials') }}" class="testimonial-back-link">
                                        <i class="fas fa-arrow-right"></i> العودة لآراء الطلاب
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="testimonial-submit-notes animate-on-scroll">
                        <div class="testimonial-submit-note">
                            <i class="fas fa-shield-alt"></i>
                            <span>جميع الآراء تمر بمراجعة يدوية قبل النشر لضمان الجودة والمصداقية.</span>
                        </div>
                        <div class="testimonial-submit-note">
                            <i class="fas fa-clock"></i>
                            <span>عادةً تتم المراجعة خلال 24–48 ساعة عمل.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
(function () {
    const courseSelect = document.getElementById('courseName');
    const courseOtherWrap = document.getElementById('courseOtherWrap');
    const courseOther = document.getElementById('courseOther');
    const quote = document.getElementById('quote');
    const quoteCount = document.getElementById('quoteCount');
    const starRating = document.getElementById('starRating');
    const ratingHint = document.getElementById('ratingHint');
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarPreviewImg = document.getElementById('avatarPreviewImg');
    const avatarRemove = document.getElementById('avatarRemove');

    const ratingLabels = {
        1: 'تقييم ضعيف — نجمة واحدة',
        2: 'تقييم مقبول — نجمتان',
        3: 'تقييم جيد — 3 نجوم',
        4: 'تقييم ممتاز — 4 نجوم',
        5: 'تقييم رائع — 5 نجوم'
    };

    function toggleCourseOther() {
        const isOther = courseSelect.value === 'other';
        courseOtherWrap.classList.toggle('d-none', !isOther);
        courseOther.required = isOther;
        if (!isOther) courseOther.value = '';
    }

    function updateQuoteCount() {
        quoteCount.textContent = quote.value.length;
    }

    function updateRatingHint() {
        const checked = starRating.querySelector('input[name="rating"]:checked');
        ratingHint.textContent = checked ? ratingLabels[checked.value] : 'اختر عدد النجوم من 1 إلى 5';
    }

    function clearAvatar() {
        avatarInput.value = '';
        avatarPreview.classList.add('d-none');
        avatarPreviewImg.src = '';
    }

    courseSelect.addEventListener('change', toggleCourseOther);
    quote.addEventListener('input', updateQuoteCount);
    starRating.querySelectorAll('input[name="rating"]').forEach(function (input) {
        input.addEventListener('change', updateRatingHint);
    });

    avatarInput.addEventListener('change', function () {
        const file = avatarInput.files[0];
        if (!file) return clearAvatar();
        const reader = new FileReader();
        reader.onload = function (e) {
            avatarPreviewImg.src = e.target.result;
            avatarPreview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });

    avatarRemove.addEventListener('click', clearAvatar);

    toggleCourseOther();
    updateQuoteCount();
    updateRatingHint();
})();
</script>
@endsection
