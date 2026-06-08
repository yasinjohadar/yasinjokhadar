@extends('frontend.layouts.master')

@section('title', 'تواصل معنا | ياسين جوخدار')
@section('description', 'تواصل مع المدرب ياسين جوخدار - للاستفسارات والتسجيل في الدورات التدريبية.')

@section('content')
    @php
        $email = $siteSettings['site_email'] ?? 'info@yasinjokhadar.net';
        $phone = $siteSettings['site_phone'] ?? '+963 XXX XXX XXX';
        $whatsapp = $siteSettings['site_whatsapp'] ?? '963XXXXXXXXX';
        $whatsappDigits = preg_replace('/\D/', '', $whatsapp);
        $address = $siteSettings['site_address'] ?? 'سوريا';
        $workingHours = $siteSettings['site_working_hours'] ?? 'السبت - الخميس: 9:00 ص - 6:00 م';
    @endphp

    <!-- ============ PAGE BANNER ============ -->
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
            <div class="contact-channels animate-on-scroll">
                <a href="https://wa.me/{{ $whatsappDigits }}" target="_blank" rel="noopener noreferrer" class="contact-channel-card contact-channel-card--whatsapp">
                    <span class="contact-channel-icon"><i class="fab fa-whatsapp"></i></span>
                    <span class="contact-channel-body">
                        <strong>واتساب</strong>
                        <small>رد سريع ومباشر</small>
                    </span>
                    <i class="fas fa-arrow-left contact-channel-arrow"></i>
                </a>
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="contact-channel-card contact-channel-card--phone">
                    <span class="contact-channel-icon"><i class="fas fa-phone-alt"></i></span>
                    <span class="contact-channel-body">
                        <strong>اتصل الآن</strong>
                        <small dir="ltr">{{ $phone }}</small>
                    </span>
                    <i class="fas fa-arrow-left contact-channel-arrow"></i>
                </a>
                <a href="mailto:{{ $email }}" class="contact-channel-card contact-channel-card--email">
                    <span class="contact-channel-icon"><i class="fas fa-envelope"></i></span>
                    <span class="contact-channel-body">
                        <strong>البريد الإلكتروني</strong>
                        <small>{{ $email }}</small>
                    </span>
                    <i class="fas fa-arrow-left contact-channel-arrow"></i>
                </a>
            </div>

            <div class="row g-4 contact-page-grid">
                <div class="col-lg-7">
                    <div class="glass-panel contact-form-card animate-on-scroll">
                        <div class="contact-form-header">
                            <span class="contact-form-header-icon"><i class="fas fa-comment-dots"></i></span>
                            <div>
                                <h2>أرسل لنا رسالة</h2>
                                <p>املأ النموذج أدناه وسنرد عليك في أقرب وقت ممكن</p>
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

                        <form id="contactForm" class="contact-form" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="contact-field-label" for="contactName">
                                        <i class="fas fa-user"></i> الاسم الكامل
                                    </label>
                                    <input type="text" id="contactName" name="name" class="contact-field @error('name') is-invalid @enderror" placeholder="أدخل اسمك الكامل" value="{{ old('name') }}" required>
                                    @error('name')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="contact-field-label" for="contactEmail">
                                        <i class="fas fa-envelope"></i> البريد الإلكتروني
                                    </label>
                                    <input type="email" id="contactEmail" name="email" class="contact-field @error('email') is-invalid @enderror" placeholder="example@email.com" value="{{ old('email') }}" required>
                                    @error('email')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="contact-field-label" for="contactPhone">
                                        <i class="fas fa-phone"></i> رقم الهاتف
                                    </label>
                                    <input type="tel" id="contactPhone" name="phone" class="contact-field @error('phone') is-invalid @enderror" placeholder="+963 XXX XXX XXX" value="{{ old('phone') }}">
                                    @error('phone')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="contact-field-label" for="contactSubject">
                                        <i class="fas fa-tag"></i> الموضوع
                                    </label>
                                    <select id="contactSubject" class="contact-field contact-field--select @error('subject') is-invalid @enderror" name="subject" required>
                                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>اختر الموضوع</option>
                                        <option value="course" {{ old('subject') === 'course' ? 'selected' : '' }}>استفسار عن دورة تدريبية</option>
                                        <option value="project" {{ old('subject') === 'project' ? 'selected' : '' }}>طلب مشروع برمجي</option>
                                        <option value="private" {{ old('subject') === 'private' ? 'selected' : '' }}>تدريب خاص</option>
                                        <option value="collab" {{ old('subject') === 'collab' ? 'selected' : '' }}>تعاون وشراكة</option>
                                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>أخرى</option>
                                    </select>
                                    @error('subject')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="contact-field-label" for="contactMessage">
                                        <i class="fas fa-pen"></i> الرسالة
                                    </label>
                                    <textarea id="contactMessage" class="contact-field contact-field--textarea @error('message') is-invalid @enderror" name="message" rows="5" placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                                    @error('message')<div class="contact-field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-primary-custom contact-submit-btn">
                                        <i class="fas fa-paper-plane"></i> إرسال الرسالة
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="contact-sidebar">
                        <div class="glass-panel contact-info-card animate-on-scroll">
                            <h3 class="contact-info-title">
                                <i class="fas fa-address-card"></i> معلومات التواصل
                            </h3>

                            <a href="mailto:{{ $email }}" class="contact-info-tile">
                                <span class="contact-info-tile-icon"><i class="fas fa-envelope"></i></span>
                                <span class="contact-info-tile-content">
                                    <strong>البريد الإلكتروني</strong>
                                    <span>{{ $email }}</span>
                                </span>
                            </a>

                            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="contact-info-tile">
                                <span class="contact-info-tile-icon"><i class="fas fa-phone-alt"></i></span>
                                <span class="contact-info-tile-content">
                                    <strong>رقم الهاتف</strong>
                                    <span dir="ltr">{{ $phone }}</span>
                                </span>
                            </a>

                            <a href="https://wa.me/{{ $whatsappDigits }}" target="_blank" rel="noopener noreferrer" class="contact-info-tile contact-info-tile--whatsapp">
                                <span class="contact-info-tile-icon"><i class="fab fa-whatsapp"></i></span>
                                <span class="contact-info-tile-content">
                                    <strong>واتساب</strong>
                                    <span dir="ltr">{{ $phone }}</span>
                                </span>
                            </a>

                            <div class="contact-info-tile contact-info-tile--static">
                                <span class="contact-info-tile-icon"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="contact-info-tile-content">
                                    <strong>الموقع</strong>
                                    <span>{{ $address }}</span>
                                </span>
                            </div>

                            <div class="contact-info-tile contact-info-tile--static">
                                <span class="contact-info-tile-icon"><i class="fas fa-clock"></i></span>
                                <span class="contact-info-tile-content">
                                    <strong>ساعات العمل</strong>
                                    <span>{{ $workingHours }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="glass-panel contact-promise-card animate-on-scroll">
                            <span class="contact-promise-icon"><i class="fas fa-bolt"></i></span>
                            <div>
                                <h4>نرد خلال 24 ساعة</h4>
                                <p>نهتم بكل رسالة ونسعى للرد بأسرع وقت ممكن خلال ساعات العمل</p>
                            </div>
                        </div>

                        <div class="glass-panel contact-social-card animate-on-scroll">
                            <h4 class="contact-social-title">تابعنا على</h4>
                            <div class="contact-social-links">
                                @if(!empty($siteSettings['facebook_url'] ?? ''))
                                <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="فيسبوك" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if(!empty($siteSettings['youtube_url'] ?? ''))
                                <a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" title="يوتيوب" aria-label="يوتيوب"><i class="fab fa-youtube"></i></a>
                                @endif
                                @if(!empty($siteSettings['instagram_url'] ?? ''))
                                <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="انستغرام" aria-label="انستغرام"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if(!empty($siteSettings['linkedin_url'] ?? ''))
                                <a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" title="لينكد إن" aria-label="لينكد إن"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if(!empty($siteSettings['github_url'] ?? ''))
                                <a href="{{ $siteSettings['github_url'] }}" target="_blank" rel="noopener noreferrer" title="جيت هاب" aria-label="جيت هاب"><i class="fab fa-github"></i></a>
                                @endif
                                @if(!empty($siteSettings['telegram_url'] ?? ''))
                                <a href="{{ $siteSettings['telegram_url'] }}" target="_blank" rel="noopener noreferrer" title="تليجرام" aria-label="تليجرام"><i class="fab fa-telegram-plane"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
