<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $fa = asset('frontend/assets');
        $cssPath = public_path('frontend/assets/css/style.css');
        $jsPath = public_path('frontend/assets/js/main.js');
        $assetVersion = max(
            file_exists($cssPath) ? filemtime($cssPath) : 0,
            file_exists($jsPath) ? filemtime($jsPath) : 0
        ) ?: time();
        view()->share('fa', $fa);
        view()->share('assetVersion', $assetVersion);
    @endphp
    @yield('meta')
    <meta name="description" content="@yield('description', 'ياسين جوخدار - مدرب ومطور برمجيات محترف. دورات تدريبية في تطوير الويب، البرمجة، وتطبيقات الموبايل.')">
    <title>@yield('title', 'ياسين جوخدار | مدرب ومطور برمجيات')</title>

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon - لوغو الموقع -->
    <link rel="icon" type="image/png" href="{{ $fa }}/images/logo.png">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'ياسين جوخدار | مدرب ومطور برمجيات')">
    <meta property="og:description" content="@yield('description', 'ياسين جوخدار - مدرب ومطور برمجيات محترف.')">
    <meta property="og:image" content="{{ $fa }}/images/logo.png">
    <meta property="og:locale" content="ar_AR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'ياسين جوخدار | مدرب ومطور برمجيات')">
    <meta name="twitter:description" content="@yield('description', 'ياسين جوخدار - مدرب ومطور برمجيات محترف.')">
    <meta name="twitter:image" content="{{ $fa }}/images/logo.png">

    <!-- Structured Data (JSON-LD) for SEO -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "ياسين جوخدار",
        "url": "{{ url('/') }}",
        "description": "مدرب ومطور برمجيات - دورات تدريبية في تطوير الويب، البرمجة وتطبيقات الموبايل",
        "inLanguage": "ar",
        "publisher": {
            "@@type": "Person",
            "name": "ياسين جوخدار",
            "url": "{{ url('/') }}",
            "jobTitle": "مدرب ومطور برمجيات"
        }
    }
    </script>

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Prism.js (syntax highlighting for code blocks) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ $fa }}/css/style.css?v={{ $assetVersion }}">
    @yield('styles')
</head>

<body>

    <!-- لودر الصفحة - اللوغو -->
    <div id="pageLoader" aria-hidden="true">
        <div class="pageLoader-inner">
            <div class="pageLoader-logo">
                <img src="{{ $fa }}/images/logo.png" alt="ياسين جوخدار" width="80" height="80">
            </div>
        </div>
    </div>

    <!-- Background Orbs -->
    <div class="bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    @include('frontend.layouts.navbar')

    @yield('content')

    @include('frontend.layouts.footer')

    <!-- Lightbox -->
    <div class="lightbox-overlay" id="lightbox" role="dialog" aria-modal="true" aria-label="عرض الصورة">
        <button class="lightbox-close" id="lightboxClose" type="button" aria-label="إغلاق"><i class="fas fa-times"></i></button>
        <div class="lightbox-stage">
            <img src="" alt="" id="lightboxImg">
            <p class="lightbox-caption" id="lightboxCaption"></p>
        </div>
    </div>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى"><i class="fas fa-chevron-up"></i></button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Prism.js core + autoloader (frontend code highlighting) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <!-- Main JS -->
    <script src="{{ $fa }}/js/main.js?v={{ $assetVersion }}"></script>
    @yield('scripts')

    <style>
        @@keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    </style>
</body>

</html>
