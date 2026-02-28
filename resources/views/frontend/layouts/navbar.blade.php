    <!-- ============ TOP BAR ============ -->
    <div class="top-bar" id="topBar">
        <div class="container">
            <div class="top-bar-inner">
                <div class="top-bar-contact">
                    <a href="mailto:{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}" class="top-bar-item"><i class="fas fa-envelope"></i><span class="top-bar-text">{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}</span></a>
                    <a href="tel:+{{ preg_replace('/\D/', '', $siteSettings['site_phone'] ?? '963XXXXXXXXX') }}" class="top-bar-item"><i class="fas fa-phone-alt"></i><span class="top-bar-text">{{ $siteSettings['site_phone'] ?? '+963 XXX XXX XXX' }}</span></a>
                </div>
                <div class="top-bar-links">
                    <a href="{{ url('/admin') }}" class="top-bar-item"><i class="fas fa-cog"></i><span class="top-bar-text">لوحة التحكم</span></a>
                    <a href="{{ route('courses') }}" class="top-bar-item"><i class="fas fa-graduation-cap"></i><span class="top-bar-text">الكورسات</span></a>
                    <a href="{{ route('videos') }}" class="top-bar-item"><i class="fas fa-play-circle"></i><span class="top-bar-text">الفيديوهات</span></a>
                    <a href="{{ route('consultation') }}" class="top-bar-item"><i class="fas fa-calendar-check"></i><span class="top-bar-text">حجز موعد</span></a>
                    <a href="{{ route('contact') }}" class="top-bar-item"><i class="fas fa-paper-plane"></i><span class="top-bar-text">تواصل معنا</span></a>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ NAVBAR ============ -->
    <nav class="navbar navbar-expand-lg main-navbar" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ $fa }}/images/logo.png" alt="ياسين جوخدار" width="45" height="45">
                <span>ياسين جوخدار</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">حول المدرب</a></li>
                    <li class="nav-item"><a href="{{ route('courses') }}" class="nav-link">الكورسات</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('projects') }}">المشاريع</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#skills">المهارات</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">معرض الصور</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog') }}">المدونة</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">تواصل معنا</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Social Icons -->
                    <div class="nav-social">
                        @if(!empty($siteSettings['facebook_url'] ?? ''))<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="فيسبوك" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($siteSettings['youtube_url'] ?? ''))<a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" title="يوتيوب" aria-label="يوتيوب"><i class="fab fa-youtube"></i></a>@endif
                        @if(!empty($siteSettings['instagram_url'] ?? ''))<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="انستغرام" aria-label="انستغرام"><i class="fab fa-instagram"></i></a>@endif
                        @if(!empty($siteSettings['linkedin_url'] ?? ''))<a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" title="لينكد إن" aria-label="لينكد إن"><i class="fab fa-linkedin-in"></i></a>@endif
                        @if(!empty($siteSettings['github_url'] ?? ''))<a href="{{ $siteSettings['github_url'] }}" target="_blank" rel="noopener noreferrer" title="جيت هاب" aria-label="جيت هاب"><i class="fab fa-github"></i></a>@endif
                        @if(!empty($siteSettings['telegram_url'] ?? ''))<a href="{{ $siteSettings['telegram_url'] }}" target="_blank" rel="noopener noreferrer" title="تليجرام" aria-label="تليجرام"><i class="fab fa-telegram-plane"></i></a>@endif
                    </div>
                    <!-- Theme Toggle -->
                    <button class="theme-toggle" id="themeToggle" title="تبديل الوضع" aria-label="تبديل الوضع الليلي/النهاري">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
