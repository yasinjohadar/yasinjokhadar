    <!-- ============ FOOTER ============ -->
    <footer class="main-footer">
        <div class="footer-top-accent" aria-hidden="true"></div>
        <div class="footer-glow footer-glow-left" aria-hidden="true"></div>
        <div class="footer-glow footer-glow-right" aria-hidden="true"></div>

        <div class="container position-relative">
            <div class="row g-4 footer-main">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <img src="{{ $fa }}/images/logo.png" alt="ياسين جوخدار" class="footer-brand-logo" width="42" height="42">
                        <span class="footer-brand-name">ياسين جوخدار</span>
                    </div>
                    <p class="footer-about">مدرب ومطور برمجيات شغوف بالتعليم ونقل المعرفة. أقدم دورات تدريبية عملية في مختلف مجالات البرمجة وتطوير الويب والموبايل.</p>
                    <div class="footer-social">
                        @if(!empty($siteSettings['facebook_url'] ?? ''))<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="فيسبوك" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($siteSettings['youtube_url'] ?? ''))<a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" title="يوتيوب" aria-label="يوتيوب"><i class="fab fa-youtube"></i></a>@endif
                        @if(!empty($siteSettings['instagram_url'] ?? ''))<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="انستغرام" aria-label="انستغرام"><i class="fab fa-instagram"></i></a>@endif
                        @if(!empty($siteSettings['linkedin_url'] ?? ''))<a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" title="لينكد إن" aria-label="لينكد إن"><i class="fab fa-linkedin-in"></i></a>@endif
                        @if(!empty($siteSettings['github_url'] ?? ''))<a href="{{ $siteSettings['github_url'] }}" target="_blank" rel="noopener noreferrer" title="جيت هاب" aria-label="جيت هاب"><i class="fab fa-github"></i></a>@endif
                        @if(!empty($siteSettings['telegram_url'] ?? ''))<a href="{{ $siteSettings['telegram_url'] }}" target="_blank" rel="noopener noreferrer" title="تليجرام" aria-label="تليجرام"><i class="fab fa-telegram-plane"></i></a>@endif
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-column">
                    <h5 class="footer-heading">روابط سريعة</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-chevron-left"></i> الرئيسية</a></li>
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-left"></i> حول المدرب</a></li>
                        <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-left"></i> الكورسات</a></li>
                        <li><a href="{{ route('projects') }}"><i class="fas fa-chevron-left"></i> المشاريع</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-column">
                    <h5 class="footer-heading">أحدث الكورسات</h5>
                    <ul class="footer-links">
                        @forelse($footerCourses ?? [] as $course)
                        <li><a href="{{ route('course.show', $course->slug) }}"><i class="fas fa-chevron-left"></i> {{ $course->title }}</a></li>
                        @empty
                        <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-left"></i> تصفّح جميع الكورسات</a></li>
                        @endforelse
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-column">
                    <h5 class="footer-heading">تواصل معنا</h5>
                    <ul class="footer-contact-list">
                        <li class="footer-contact-item">
                            <span class="footer-contact-icon"><i class="fas fa-envelope"></i></span>
                            <a href="mailto:{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}">{{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}</a>
                        </li>
                        <li class="footer-contact-item">
                            <span class="footer-contact-icon"><i class="fas fa-phone"></i></span>
                            <a href="tel:{{ preg_replace('/\s+/', '', $siteSettings['site_phone'] ?? '') }}">{{ $siteSettings['site_phone'] ?? '+963 XXX XXX XXX' }}</a>
                        </li>
                        <li class="footer-contact-item">
                            <span class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <span>{{ $siteSettings['site_address'] ?? 'سوريا' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-newsletter-strip">
                <div class="footer-newsletter-strip-inner">
                    <div class="footer-newsletter-strip-content">
                        <span class="footer-newsletter-strip-badge">النشرة البريدية</span>
                        <h3 class="footer-newsletter-strip-title"><i class="fas fa-paper-plane"></i> اشترك ليصلك كل جديد</h3>
                        <p class="footer-newsletter-strip-desc">مقالات، عروض، وأخبار الدورات مباشرة في بريدك</p>
                    </div>
                    <div class="footer-newsletter-strip-form">
                        @include('frontend.partials.newsletter-form', ['source' => 'footer', 'variant' => 'footer-strip'])
                        <p class="footer-newsletter-strip-privacy">
                            <i class="fas fa-shield-alt"></i> نحترم خصوصيتك ولا نشارك بريدك مع أي جهة
                        </p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="footer-copyright">جميع الحقوق محفوظة &copy; {{ date('Y') }} <span>ياسين جوخدار</span> | صُنع بـ ❤️</p>
                <div class="footer-bottom-links">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('contact') }}">تواصل معنا</a>
                </div>
            </div>
        </div>
    </footer>
