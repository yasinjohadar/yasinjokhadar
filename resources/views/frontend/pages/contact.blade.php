@extends('frontend.layouts.master')

@section('title', 'تواصل معنا | ياسين جوخدار')
@section('description', 'تواصل مع المدرب ياسين جوخدار - للاستفسارات والتسجيل في الدورات التدريبية.')

@section('content')
    <!-- ============ PAGE BANNER (تواصل معنا) ============ -->
    <section class="page-banner page-banner-contact">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-paper-plane"></i></div>
                <h1 class="page-banner-title">تواصل <span>معنا</span></h1>
                <p class="page-banner-desc">نحن هنا لمساعدتك — للاستفسارات أو التسجيل في الدورات أو طلب استشارة تقنية</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>تواصل معنا</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ CONTACT SECTION ============ -->
    <section class="section-padding contact-page-section">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="glass-panel contact-form-wrapper animate-on-scroll">
                        <h4 style="font-weight:800; margin-bottom:8px;">أرسل لنا رسالة</h4>
                        <p style="color:var(--clr-text-secondary); margin-bottom:25px; font-size:0.95rem;">
                            املأ النموذج أدناه وسنرد عليك في أقرب وقت ممكن
                        </p>

                        @if(session('success'))
                            <div class="alert alert-success mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger mb-4" role="alert">
                                <strong>يرجى تصحيح الأخطاء التالية:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">الاسم الكامل</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="أدخل اسمك الكامل" value="{{ old('name') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@email.com" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">رقم الهاتف</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+963 XXX XXX XXX" value="{{ old('phone') }}">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">الموضوع</label>
                                    <select class="form-select @error('subject') is-invalid @enderror" name="subject" required>
                                        <option value="" disabled selected>اختر الموضوع</option>
                                        <option value="course" {{ old('subject') === 'course' ? 'selected' : '' }}>استفسار عن دورة تدريبية</option>
                                        <option value="project" {{ old('subject') === 'project' ? 'selected' : '' }}>طلب مشروع برمجي</option>
                                        <option value="private" {{ old('subject') === 'private' ? 'selected' : '' }}>تدريب خاص</option>
                                        <option value="collab" {{ old('subject') === 'collab' ? 'selected' : '' }}>تعاون وشراكة</option>
                                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>أخرى</option>
                                    </select>
                                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label" style="font-weight:600; font-size:0.9rem;">الرسالة</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="5" placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-primary-custom w-100" style="justify-content:center;">
                                        <i class="fas fa-paper-plane"></i> إرسال الرسالة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="glass-panel contact-info-card animate-on-scroll" style="margin-bottom:20px;">
                        <h4 style="font-weight:800; margin-bottom:20px;">معلومات التواصل</h4>
                        <div class="contact-info-item">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h6>البريد الإلكتروني</h6>
                                <p>{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                            <div>
                                <h6>رقم الهاتف</h6>
                                <p style="direction:ltr; text-align:right;">{{ $siteSettings['site_phone'] ?? '+963 XXX XXX XXX' }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="info-icon"><i class="fab fa-whatsapp"></i></div>
                            <div>
                                <h6>واتساب</h6>
                                <p style="direction:ltr; text-align:right;">{{ $siteSettings['site_phone'] ?? '+963 XXX XXX XXX' }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <h6>الموقع</h6>
                                <p>{{ $siteSettings['site_address'] ?? 'سوريا' }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item" style="margin-bottom:0;">
                            <div class="info-icon"><i class="fas fa-clock"></i></div>
                            <div>
                                <h6>ساعات العمل</h6>
                                <p>{{ $siteSettings['site_working_hours'] ?? 'السبت - الخميس: 9:00 ص - 6:00 م' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
