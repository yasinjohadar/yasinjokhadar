    <header class="site-header" id="siteHeader">
        <!-- ============ TOP BAR ============ -->
        <div class="top-bar" id="topBar">
            <div class="container">
                <div class="top-bar-inner">
                    <div class="top-bar-contact">
                        <a href="mailto:{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}" class="top-bar-item">
                            <i class="fas fa-envelope"></i>
                            <span class="top-bar-text">{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}</span>
                        </a>
                        <span class="top-bar-divider" aria-hidden="true"></span>
                        <a href="tel:+{{ preg_replace('/\D/', '', $siteSettings['site_phone'] ?? '963XXXXXXXXX') }}" class="top-bar-item">
                            <i class="fas fa-phone-alt"></i>
                            <span class="top-bar-text">{{ $siteSettings['site_phone'] ?? '+963 XXX XXX XXX' }}</span>
                        </a>
                    </div>
                    <div class="top-bar-links">
                        <a href="{{ url('/admin') }}" class="top-bar-chip"><i class="fas fa-cog"></i><span>لوحة التحكم</span></a>
                        <a href="{{ route('courses') }}" class="top-bar-chip"><i class="fas fa-graduation-cap"></i><span>الكورسات</span></a>
                        <a href="{{ route('videos') }}" class="top-bar-chip"><i class="fas fa-play-circle"></i><span>الفيديوهات</span></a>
                        <a href="{{ route('consultation') }}" class="top-bar-chip top-bar-chip--accent"><i class="fas fa-calendar-check"></i><span>حجز موعد</span></a>
                        <a href="{{ route('contact') }}" class="top-bar-chip"><i class="fas fa-paper-plane"></i><span>تواصل معنا</span></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ NAVBAR ============ -->
        <nav class="navbar navbar-expand-lg main-navbar" id="mainNavbar">
            <div class="container navbar-shell">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="navbar-brand-logo">
                        <img src="{{ $fa }}/images/logo.png" alt="ياسين جوخدار" width="46" height="46">
                    </span>
                    <span class="navbar-brand-text">
                        <strong>ياسين جوخدار</strong>
                        <small>مدرب ومطور برمجيات</small>
                    </span>
                </a>

                <div class="navbar-actions-mobile d-lg-none">
                    <button class="theme-toggle theme-toggle--compact" id="themeToggleMobile" title="تبديل الوضع" aria-label="تبديل الوضع الليلي/النهاري">
                        <i class="fas fa-moon"></i>
                        <i class="fas fa-sun"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="فتح القائمة">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><span>الرئيسية</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}"><span>حول المدرب</span></a></li>
                        <li class="nav-item"><a href="{{ route('courses') }}" class="nav-link"><span>الكورسات</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('projects') }}"><span>المشاريع</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#skills"><span>المهارات</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}"><span>معرض الصور</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('blog') }}"><span>المدونة</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}"><span>تواصل معنا</span></a></li>
                    </ul>

                    <div class="navbar-actions">
                        <div class="nav-social">
                            @if(!empty($siteSettings['facebook_url'] ?? ''))<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="فيسبوك" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>@endif
                            @if(!empty($siteSettings['youtube_url'] ?? ''))<a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" title="يوتيوب" aria-label="يوتيوب"><i class="fab fa-youtube"></i></a>@endif
                            @if(!empty($siteSettings['instagram_url'] ?? ''))<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="انستغرام" aria-label="انستغرام"><i class="fab fa-instagram"></i></a>@endif
                            @if(!empty($siteSettings['linkedin_url'] ?? ''))<a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" title="لينكد إن" aria-label="لينكد إن"><i class="fab fa-linkedin-in"></i></a>@endif
                            @if(!empty($siteSettings['github_url'] ?? ''))<a href="{{ $siteSettings['github_url'] }}" target="_blank" rel="noopener noreferrer" title="جيت هاب" aria-label="جيت هاب"><i class="fab fa-github"></i></a>@endif
                            @if(!empty($siteSettings['telegram_url'] ?? ''))<a href="{{ $siteSettings['telegram_url'] }}" target="_blank" rel="noopener noreferrer" title="تليجرام" aria-label="تليجرام"><i class="fab fa-telegram-plane"></i></a>@endif
                        </div>

                        <button class="theme-toggle d-none d-lg-flex" id="themeToggle" title="تبديل الوضع" aria-label="تبديل الوضع الليلي/النهاري">
                            <i class="fas fa-moon"></i>
                            <i class="fas fa-sun"></i>
                        </button>

                        <a href="{{ route('consultation') }}" class="nav-cta-btn">
                            <i class="fas fa-calendar-check"></i>
                            <span>حجز موعد</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
