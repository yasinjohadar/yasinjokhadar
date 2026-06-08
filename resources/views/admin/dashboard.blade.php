@extends('admin.layouts.master')

@section('page-title')
لوحة التحكم
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid dash-pro">

        <div class="dash-pro-welcome">
            <div>
                <h4>مرحباً {{ auth()->user()->name ?? 'المدير' }}، أهلاً بعودتك!</h4>
                <p>لوحة تحكم مركز الإدارة — نظرة شاملة على المحتوى والطلبات والإعدادات.</p>
            </div>
            <span class="dash-pro-role-badge">
                <i class="bi bi-shield-check"></i>
                أنت مسجل الدخول كأدمن
            </span>
        </div>

        @if($summary['unread_total'] > 0 || $pendingTestimonials > 0)
        <div class="dash-pro-alert" role="alert">
            <i class="bi bi-bell-fill text-warning fs-5"></i>
            <div class="flex-grow-1">
                <strong>تنبيهات تحتاج انتباهك:</strong>
                @if($unreadMessages > 0)<span class="ms-2">{{ $unreadMessages }} رسالة تواصل</span>@endif
                @if($unreadConsultations > 0)<span class="ms-2">{{ $unreadConsultations }} طلب استشارة</span>@endif
                @if($pendingTestimonials > 0)<span class="ms-2">{{ $pendingTestimonials }} رأي طالب بانتظار المراجعة</span>@endif
            </div>
            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-warning-light">عرض الرسائل</a>
        </div>
        @endif

        <div class="dash-pro-hero-grid">
            @foreach($heroStats as $stat)
            <article class="dash-pro-hero-card dash-pro-hero-card--{{ $stat['tone'] }}">
                <div class="dash-pro-hero-content">
                    <div class="dash-pro-hero-text">
                        <p>{{ $stat['title'] }}</p>
                        <h3>{{ number_format($stat['count']) }}</h3>
                        <span>{{ $stat['meta'] }}</span>
                    </div>
                    <span class="dash-pro-hero-icon" aria-hidden="true">
                        <i class="bi {{ $stat['icon'] }}"></i>
                    </span>
                </div>
            </article>
            @endforeach
        </div>

        <section class="dash-pro-panel">
            <div class="dash-pro-panel-header">
                <div>
                    <h5><i class="bi bi-lightning-charge-fill text-warning"></i> اختصارات سريعة</h5>
                    <p>وصول مباشر لأهم أقسام لوحة التحكم — إدارة المحتوى، التواصل، والإعدادات.</p>
                </div>
                <span class="badge bg-primary-transparent text-primary px-3 py-2">
                    <i class="bi bi-grid-3x3-gap me-1"></i>
                    {{ count($shortcuts) }} قسم
                </span>
            </div>
            <div class="dash-pro-panel-body">
                <div class="dash-pro-shortcuts-grid">
                    @foreach($shortcuts as $shortcut)
                    @php
                        $tone = str_replace('dash-widget--', 'dash-pro-shortcut--', $shortcut['color']);
                    @endphp
                    <a href="{{ $shortcut['url'] }}" class="dash-pro-shortcut {{ $tone }}">
                        <span class="dash-pro-shortcut-icon">
                            <i class="bi {{ $shortcut['icon'] }}"></i>
                        </span>
                        <h6>{{ $shortcut['title'] }}</h6>
                        <p>
                            {{ $shortcut['description'] ?? 'فتح القسم وإدارته' }}
                        </p>
                        @if($shortcut['badge'])
                            <span class="dash-pro-shortcut-badge">{{ $shortcut['badge'] }}</span>
                        @elseif(!is_null($shortcut['count']))
                            <span class="dash-pro-shortcut-meta">{{ number_format($shortcut['count']) }} عنصر</span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="dash-pro-bottom-grid">
            <div class="dash-pro-card">
                <div class="dash-pro-card-header">
                    <h6><i class="bi bi-sunrise-fill text-warning"></i> ملخص اليوم</h6>
                    <small class="text-muted">{{ now()->translatedFormat('d F Y') }}</small>
                </div>
                <div class="dash-pro-card-body">
                    @foreach($todaySummary as $item)
                    <div class="dash-pro-today-item">
                        <span class="dash-pro-today-label">
                            <span class="dash-pro-today-icon dash-pro-today-icon--{{ $item['tone'] }}">
                                <i class="bi {{ $item['icon'] }}"></i>
                            </span>
                            {{ $item['label'] }}
                        </span>
                        <span class="dash-pro-today-value">{{ number_format($item['value']) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="dash-pro-card">
                <div class="dash-pro-card-header">
                    <h6><i class="bi bi-graph-up-arrow text-primary"></i> تطور التواصل خلال آخر 6 أشهر</h6>
                </div>
                <div class="dash-pro-card-body">
                    <div id="dashActivityChart"></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-6">
                <div class="dash-pro-card">
                    <div class="dash-pro-card-header">
                        <h6><i class="bi bi-envelope-open text-primary"></i> آخر رسائل التواصل</h6>
                        <a href="{{ route('admin.contact-messages.index') }}" class="dash-pro-activity-link">عرض الكل</a>
                    </div>
                    <div class="dash-pro-card-body">
                        @forelse($recentMessages as $message)
                        <div class="dash-pro-activity-item">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <strong>{{ $message->name }}</strong>
                                    @if(!$message->is_read)
                                        <span class="badge bg-warning-transparent text-warning ms-1">جديد</span>
                                    @endif
                                    <div class="text-muted fs-12">{{ \App\Models\ContactMessage::subjectLabel($message->subject) }}</div>
                                    <div class="text-muted fs-12 text-truncate" style="max-width: 280px;">{{ Str::limit($message->message, 60) }}</div>
                                </div>
                                <small class="text-muted text-nowrap">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0 py-3">لا توجد رسائل حالياً.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="dash-pro-card">
                    <div class="dash-pro-card-header">
                        <h6><i class="bi bi-calendar-event text-success"></i> آخر طلبات الاستشارة</h6>
                        <a href="{{ route('admin.consultation-requests.index') }}" class="dash-pro-activity-link">عرض الكل</a>
                    </div>
                    <div class="dash-pro-card-body">
                        @forelse($recentConsultations as $request)
                        <div class="dash-pro-activity-item">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <strong>{{ $request->name }}</strong>
                                    @if(!$request->is_read)
                                        <span class="badge bg-success-transparent text-success ms-1">جديد</span>
                                    @endif
                                    <div class="text-muted fs-12">{{ \App\Models\ConsultationRequest::consultationTypeLabel($request->consultation_type) }}</div>
                                    <div class="text-muted fs-12">{{ $request->preferred_date?->format('Y-m-d') ?? '—' }} {{ $request->preferred_time ?? '' }}</div>
                                </div>
                                <small class="text-muted text-nowrap">{{ $request->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0 py-3">لا توجد طلبات حالياً.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.1/dist/apexcharts.min.js"></script>
<script>
(function () {
    const chartEl = document.querySelector('#dashActivityChart');
    if (!chartEl || typeof ApexCharts === 'undefined') {
        return;
    }

    const isDark = document.documentElement.getAttribute('data-theme-mode') === 'dark';
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : '#eef2f7';
    const chartData = @json($activityChart);

    const chart = new ApexCharts(chartEl, {
        series: chartData.series,
        chart: {
            type: 'area',
            height: 320,
            fontFamily: 'inherit',
            toolbar: { show: false },
            zoom: { enabled: false },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 700
            }
        },
        colors: ['#0162e8', '#22c03c'],
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.35,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        grid: {
            borderColor: gridColor,
            strokeDashArray: 4
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left',
            labels: { colors: textColor }
        },
        xaxis: {
            categories: chartData.labels,
            labels: {
                style: {
                    colors: textColor,
                    fontSize: '11px',
                    fontWeight: 600
                }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                style: {
                    colors: textColor,
                    fontSize: '11px',
                    fontWeight: 600
                }
            }
        },
        tooltip: {
            theme: isDark ? 'dark' : 'light'
        }
    });

    chart.render();

    function refreshChartTheme() {
        const dark = document.documentElement.getAttribute('data-theme-mode') === 'dark';
        const labelColor = dark ? '#94a3b8' : '#64748b';
        const borderColor = dark ? 'rgba(255,255,255,0.06)' : '#eef2f7';

        chart.updateOptions({
            grid: { borderColor },
            legend: { labels: { colors: labelColor } },
            xaxis: { labels: { style: { colors: labelColor } } },
            yaxis: { labels: { style: { colors: labelColor } } },
            tooltip: { theme: dark ? 'dark' : 'light' }
        }, false, false);
    }

    const themeObserver = new MutationObserver(refreshChartTheme);
    themeObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['data-theme-mode']
    });
})();
</script>
@stop
