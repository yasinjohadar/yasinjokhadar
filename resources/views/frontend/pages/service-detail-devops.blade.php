@extends('frontend.layouts.master')

@section('title', 'DevOps وتشغيل المنصات | ياسين جوخدار')
@section('description', 'DevOps — تكامل ونشر مستمر (CI/CD)، حاويات وكوبرنيتس، البنية كود (IaC)، سحابة ومراقبة مع ياسين جوخدار.')

@section('content')
    @php
        $devopsCategories = [
            [
                'title' => 'CI/CD وبناء الأنابيب',
                'icon' => 'fas fa-sync-alt',
                'technologies' => [
                    ['name' => 'Jenkins', 'icon' => 'fas fa-cogs', 'color' => '#D24939'],
                    ['name' => 'GitLab CI/CD', 'icon' => 'fab fa-gitlab', 'color' => '#FC6D26'],
                    ['name' => 'GitHub Actions', 'icon' => 'fab fa-github', 'color' => '#181717'],
                    ['name' => 'CircleCI', 'icon' => 'fas fa-circle-notch', 'color' => '#343434'],
                    ['name' => 'Travis CI', 'icon' => 'fas fa-code-branch', 'color' => '#3EAAAF'],
                    ['name' => 'Azure DevOps', 'icon' => 'fab fa-microsoft', 'color' => '#0078D4'],
                    ['name' => 'Argo CD', 'icon' => 'fas fa-ship', 'color' => '#EF7B4D'],
                    ['name' => 'Flux', 'icon' => 'fas fa-water', 'color' => '#5468FF'],
                ],
            ],
            [
                'title' => 'حاويات وأوركستريشن',
                'icon' => 'fab fa-docker',
                'technologies' => [
                    ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ED'],
                    ['name' => 'Kubernetes', 'icon' => 'fas fa-dharmachakra', 'color' => '#326CE5'],
                    ['name' => 'Helm', 'icon' => 'fas fa-anchor', 'color' => '#0F1689'],
                    ['name' => 'Kustomize', 'icon' => 'fas fa-layer-group', 'color' => '#326CE5'],
                    ['name' => 'Docker Compose', 'icon' => 'fab fa-docker', 'color' => '#2496ED'],
                    ['name' => 'containerd', 'icon' => 'fas fa-box', 'color' => '#575757'],
                    ['name' => 'Podman', 'icon' => 'fas fa-cube', 'color' => '#892CA0'],
                    ['name' => 'Rancher', 'icon' => 'fas fa-cow', 'color' => '#0075A8'],
                ],
            ],
            [
                'title' => 'سحابة ومنصات',
                'icon' => 'fas fa-cloud',
                'technologies' => [
                    ['name' => 'AWS', 'icon' => 'fab fa-aws', 'color' => '#FF9900'],
                    ['name' => 'Azure', 'icon' => 'fab fa-microsoft', 'color' => '#0078D4'],
                    ['name' => 'Google Cloud', 'icon' => 'fab fa-google', 'color' => '#4285F4'],
                    ['name' => 'DigitalOcean', 'icon' => 'fab fa-digital-ocean', 'color' => '#0080FF'],
                    ['name' => 'EKS / AKS / GKE', 'icon' => 'fas fa-dharmachakra', 'color' => '#326CE5'],
                    ['name' => 'Lambda / Serverless', 'icon' => 'fas fa-bolt', 'color' => '#FF9900'],
                ],
            ],
            [
                'title' => 'بنية كود وإدارة تكوين (IaC)',
                'icon' => 'fas fa-code-branch',
                'technologies' => [
                    ['name' => 'Terraform', 'icon' => 'fas fa-mountain', 'color' => '#844FBA'],
                    ['name' => 'Ansible', 'icon' => 'fas fa-robot', 'color' => '#EE0000'],
                    ['name' => 'Puppet', 'icon' => 'fas fa-theater-masks', 'color' => '#FFAE1A'],
                    ['name' => 'Chef', 'icon' => 'fas fa-utensils', 'color' => '#F09820'],
                    ['name' => 'Pulumi', 'icon' => 'fas fa-cloud-upload-alt', 'color' => '#8A3391'],
                    ['name' => 'CloudFormation', 'icon' => 'fab fa-aws', 'color' => '#FF9900'],
                ],
            ],
            [
                'title' => 'مراقبة وسجلات وأمان',
                'icon' => 'fas fa-chart-line',
                'technologies' => [
                    ['name' => 'Prometheus', 'icon' => 'fas fa-fire', 'color' => '#E6522C'],
                    ['name' => 'Grafana', 'icon' => 'fas fa-chart-area', 'color' => '#F46800'],
                    ['name' => 'ELK Stack', 'icon' => 'fas fa-search', 'color' => '#005571'],
                    ['name' => 'Datadog', 'icon' => 'fas fa-dog', 'color' => '#632CA6'],
                    ['name' => 'Nagios / Zabbix', 'icon' => 'fas fa-heartbeat', 'color' => '#1A1A1A'],
                    ['name' => 'HashiCorp Vault', 'icon' => 'fas fa-vault', 'color' => '#000000'],
                    ['name' => 'Jaeger', 'icon' => 'fas fa-route', 'color' => '#66C3D0'],
                ],
            ],
            [
                'title' => 'أنظمة وخدمات أساسية',
                'icon' => 'fas fa-server',
                'technologies' => [
                    ['name' => 'Linux / Ubuntu', 'icon' => 'fab fa-linux', 'color' => '#FCC624'],
                    ['name' => 'Nginx', 'icon' => 'fas fa-server', 'color' => '#009639'],
                    ['name' => 'Apache', 'icon' => 'fas fa-feather-alt', 'color' => '#D22128'],
                    ['name' => 'Git / GitLab', 'icon' => 'fab fa-gitlab', 'color' => '#FC6D26'],
                    ['name' => 'Bash / Python', 'icon' => 'fab fa-python', 'color' => '#3776AB'],
                    ['name' => 'RabbitMQ / Kafka', 'icon' => 'fas fa-stream', 'color' => '#FF6600'],
                    ['name' => 'Redis', 'icon' => 'fas fa-bolt', 'color' => '#DC382D'],
                    ['name' => 'Istio / Linkerd', 'icon' => 'fas fa-network-wired', 'color' => '#466BB0'],
                ],
            ],
        ];
    @endphp

    <!-- ============ SERVICE BANNER ============ -->
    <section class="page-banner page-banner-service">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-infinity"></i></div>
                <h1 class="page-banner-title">DevOps <span>وتشغيل المنصات</span></h1>
                <p class="page-banner-desc">تكامل ونشر مستمر (CI/CD)، حاويات وأوركستريشن، بنية كود (IaC)، سحابة ومراقبة — من البناء حتى التشغيل الآلي</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <a href="{{ route('about') }}#specialties">التخصصات</a>
                    <span class="page-banner-sep">/</span>
                    <span>DevOps</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ SERVICE INTRO ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="service-detail-intro animate-on-scroll">
                        <span class="section-badge">نظرة عامة</span>
                        <h2 class="service-detail-heading">ماذا نقدم في DevOps؟</h2>
                        <p class="service-detail-lead">
                            أقدم حلولاً متكاملة في ثقافة ومنهجية DevOps: أتمتة البناء والاختبار والنشر (CI/CD)، إدارة الحاويات والأوركستريشن (Docker و Kubernetes)، البنية كود (Terraform، Ansible)، والعمل على منصات سحابية (AWS، Azure، GCP) مع مراقبة وسجلات وضمان استقرار وتوفر الخدمات.
                        </p>
                        <p class="service-detail-text">
                            نربط بين التطوير والتشغيل عبر خطوط أنابيب أوتوماتيكية، بيئات قابلة للتكرار، ومراقبة الأداء والسجلات. سواء مشروعك على سيرفرات تقليدية أو سحابة أو كوبرنيتس — نضع معك البنية والعمليات المناسبة وتدريب الفريق إن لزم.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="glass-panel service-detail-feature-list animate-on-scroll">
                        <h4 class="service-detail-feature-list-title"><i class="fas fa-check-circle"></i> أبرز ما يميز الخدمة</h4>
                        <ul class="service-detail-feature-list-ul">
                            <li><i class="fas fa-chevron-left"></i> خطوط أنابيب CI/CD (Jenkins، GitLab CI، GitHub Actions)</li>
                            <li><i class="fas fa-chevron-left"></i> حاويات وأوركستريشن (Docker، Kubernetes، Helm)</li>
                            <li><i class="fas fa-chevron-left"></i> بنية كود IaC (Terraform، Ansible)</li>
                            <li><i class="fas fa-chevron-left"></i> نشر على سحابة (AWS، Azure، GCP)</li>
                            <li><i class="fas fa-chevron-left"></i> مراقبة وسجلات (Prometheus، Grafana، ELK)</li>
                            <li><i class="fas fa-chevron-left"></i> أتمتة وإدارة تكوين موحّدة</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT WE OFFER ============ -->
    <section class="section-padding" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">تفاصيل الخدمة</span>
                <h2>ما الذي يشمل عليه العمل؟</h2>
                <p>مراحل ومنتجات واضحة في كل مشروع DevOps</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="glass-panel service-offer-card animate-on-scroll">
                        <div class="service-offer-icon"><i class="fas fa-sync-alt"></i></div>
                        <h5>CI/CD — تكامل ونشر مستمر</h5>
                        <p>إعداد خطوط أنابيب للبناء والاختبار والنشر التلقائي (Jenkins، GitLab CI، GitHub Actions، Azure DevOps) مع إدارة البيئات والسرّات.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-panel service-offer-card animate-on-scroll">
                        <div class="service-offer-icon"><i class="fab fa-docker"></i></div>
                        <h5>حاويات وأوركستريشن</h5>
                        <p>إعداد حاويات (Containerization) بـ Docker، إدارة Clusters بـ Kubernetes (K8s)، Helm و Kustomize، واختياراً Docker Swarm أو منصات مُدارة (EKS، AKS، GKE).</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-panel service-offer-card animate-on-scroll">
                        <div class="service-offer-icon"><i class="fas fa-code-branch"></i></div>
                        <h5>البنية كود (IaC)</h5>
                        <p>توفير البنية وتجهيز السيرفرات عبر Terraform و Ansible (أو Puppet/Chef) لبيئات قابلة للتكرار وقابلة للإصدار.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-panel service-offer-card animate-on-scroll">
                        <div class="service-offer-icon"><i class="fas fa-cloud"></i></div>
                        <h5>السحابة والخدمات المُدارة</h5>
                        <p>نشر على AWS أو Azure أو GCP أو DigitalOcean: حسابات، شبكات، تخزين، قواعد بيانات مُدارة، وخدمات serverless حيث يناسب.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-panel service-offer-card animate-on-scroll">
                        <div class="service-offer-icon"><i class="fas fa-chart-line"></i></div>
                        <h5>المراقبة والسجلات</h5>
                        <p>إعداد Prometheus و Grafana للمقاييس والتنبيهات، و/أو ELK/EFK stack للسجلات، مع لوحات ودمج مع أنظمة الحوادث.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="glass-panel service-offer-card animate-on-scroll">
                        <div class="service-offer-icon"><i class="fas fa-robot"></i></div>
                        <h5>أتمتة وسكريبتات</h5>
                        <p>سكريبتات Bash/Python للصيانة والنسخ الاحتياطي، إدارة التكوين الموحّد، وربط الأدوات في سير عمل واحد.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding service-tech-section">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">التقنيات</span>
                <h2>تقنيات DevOps — شاملة</h2>
                <p>أدوات ومنصات نعتمد عليها في التكامل والنشر والحاويات والسحابة والمراقبة</p>
            </div>

            @foreach($devopsCategories as $category)
            <div class="service-devops-tech-section animate-on-scroll">
                <h5 class="service-devops-tech-cat"><i class="{{ $category['icon'] }}"></i> {{ $category['title'] }}</h5>
                <div class="glass-panel service-tech-wrap">
                    @include('frontend.partials.service-tech-grid', ['technologies' => $category['technologies']])
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ============ RELATED SERVICES ============ -->
    <section class="section-padding" style="background: var(--clr-bg-secondary);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <span class="section-badge">تخصصات أخرى</span>
                <h2>خدمات وتخصصات ذات صلة</h2>
                <p>اطّلع على مجالات أخرى نقدم فيها الاستشارة والتنفيذ</p>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('service.show', 'web') }}" class="service-related-card glass-panel animate-on-scroll">
                        <i class="fas fa-globe"></i>
                        <h6>تطوير تطبيقات الويب</h6>
                        <p>مواقع وتطبيقات ويب بـ React و Node.js</p>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('service.show', 'mobile') }}" class="service-related-card glass-panel animate-on-scroll">
                        <i class="fas fa-mobile-alt"></i>
                        <h6>تطبيقات الجوال</h6>
                        <p>تطوير تطبيقات أندرويد و iOS</p>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('service.show', 'security') }}" class="service-related-card glass-panel animate-on-scroll">
                        <i class="fas fa-shield-alt"></i>
                        <h6>أمن المعلومات</h6>
                        <p>حماية الأنظمة والبيانات وتقييم الثغرات</p>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a href="{{ route('service.show', 'servers') }}" class="service-related-card glass-panel animate-on-scroll">
                        <i class="fas fa-server"></i>
                        <h6>إدارة السيرفرات</h6>
                        <p>إعداد وإدارة الخوادم والاستضافة</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="cta-section">
        <div class="container animate-on-scroll">
            <h2>هل تحتاج بنية DevOps أو أتمتة نشر لمشروعك؟</h2>
            <p>تواصل معنا الآن ونناقش متطلباتك ونقدم لك عرضاً tailored لاحتياجاتك</p>
            <a href="{{ route('contact') }}" class="btn-light-custom">
                <i class="fas fa-paper-plane"></i> تواصل معنا
            </a>
        </div>
    </section>

@endsection
