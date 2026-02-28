    <!-- ============ FOOTER ============ -->
    <footer class="main-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5><img src="{{ $fa }}/images/logo.png" alt="لوغو"
                            style="width:35px; height:35px; border-radius:50%; margin-left:8px; border:2px solid var(--clr-primary);" width="35" height="35">ياسين
                        جوخدار</h5>
                    <p>مدرب ومطور برمجيات شغوف بالتعليم ونقل المعرفة. أقدم دورات تدريبية عملية في مختلف مجالات البرمجة
                        وتطوير الويب والموبايل.</p>
                    <div class="footer-social">
                        @if(!empty($siteSettings['facebook_url'] ?? ''))<a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="فيسبوك" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($siteSettings['youtube_url'] ?? ''))<a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" title="يوتيوب" aria-label="يوتيوب"><i class="fab fa-youtube"></i></a>@endif
                        @if(!empty($siteSettings['instagram_url'] ?? ''))<a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="انستغرام" aria-label="انستغرام"><i class="fab fa-instagram"></i></a>@endif
                        @if(!empty($siteSettings['linkedin_url'] ?? ''))<a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" title="لينكد إن" aria-label="لينكد إن"><i class="fab fa-linkedin-in"></i></a>@endif
                        @if(!empty($siteSettings['github_url'] ?? ''))<a href="{{ $siteSettings['github_url'] }}" target="_blank" rel="noopener noreferrer" title="جيت هاب" aria-label="جيت هاب"><i class="fab fa-github"></i></a>@endif
                        @if(!empty($siteSettings['telegram_url'] ?? ''))<a href="{{ $siteSettings['telegram_url'] }}" target="_blank" rel="noopener noreferrer" title="تليجرام" aria-label="تليجرام"><i class="fab fa-telegram-plane"></i></a>@endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>روابط سريعة</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-chevron-left"></i> الرئيسية</a></li>
                        <li><a href="{{ route('about') }}"><i class="fas fa-chevron-left"></i> حول المدرب</a></li>
                        <li><a href="{{ route('courses') }}"><i class="fas fa-chevron-left"></i> الكورسات</a></li>
                        <li><a href="{{ route('projects') }}"><i class="fas fa-chevron-left"></i> المشاريع</a></li>
                        <li><a href="{{ route('videos') }}"><i class="fas fa-chevron-left"></i> الفيديوهات</a></li>
                        <li><a href="{{ route('testimonials') }}"><i class="fas fa-chevron-left"></i> آراء الطلاب</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-left"></i> تواصل معنا</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>أحدث الكورسات</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-left"></i> تطوير الويب الشامل</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> بايثون للمبتدئين</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> Flutter للموبايل</a></li>
                        <li><a href="#"><i class="fas fa-chevron-left"></i> WordPress المتقدم</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>تواصل معنا</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope" style="color: var(--clr-primary); margin-left:8px;"></i>
                            {{ $siteSettings['site_email'] ?? 'info@yasinjokhadar.net' }}</li>
                        <li><i class="fas fa-phone" style="color: var(--clr-primary); margin-left:8px;"></i> {{ $siteSettings['site_phone'] ?? '+963 XXX XXX XXX' }}</li>
                        <li><i class="fas fa-map-marker-alt" style="color: var(--clr-primary); margin-left:8px;"></i>
                            {{ $siteSettings['site_address'] ?? 'سوريا' }}</li>
                    </ul>
                    <div class="footer-newsletter mt-4">
                        <h6 class="footer-newsletter-title">النشرة البريدية</h6>
                        <p class="footer-newsletter-desc">اشترك ليصلك كل جديد</p>
                        @include('frontend.partials.newsletter-form', ['source' => 'footer', 'variant' => 'footer'])
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                جميع الحقوق محفوظة &copy; 2026 <span>ياسين جوخدار</span> | صُنع بـ ❤️
            </div>
        </div>
    </footer>
