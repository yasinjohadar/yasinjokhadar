@extends('admin.layouts.master')

@section('page-title')
لوحة التحكم
@stop

@section('styles')
<style>
    .dash-summary-card {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dash-summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
    }
    [data-theme-mode="dark"] .dash-summary-card:hover {
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
    }
    .dash-summary-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .dash-widget {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-radius: 16px;
        text-decoration: none !important;
        color: inherit;
        border: 1px solid var(--default-border);
        background: var(--custom-white);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        height: 100%;
    }
    .dash-widget:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08);
        border-color: transparent;
        color: inherit;
    }
    [data-theme-mode="dark"] .dash-widget {
        background: rgb(var(--body-bg-rgb));
    }
    [data-theme-mode="dark"] .dash-widget:hover {
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.35);
    }
    .dash-widget-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        flex-shrink: 0;
        color: #fff;
    }
    .dash-widget-body h6 {
        margin: 0 0 4px;
        font-weight: 700;
        font-size: 0.95rem;
    }
    .dash-widget-body .dash-widget-count {
        font-size: 1.35rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 0;
    }
    .dash-widget-body .dash-widget-meta {
        font-size: 0.78rem;
        margin-top: 4px;
        opacity: 0.85;
    }
    .dash-widget-arrow {
        margin-inline-start: auto;
        opacity: 0.35;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    .dash-widget:hover .dash-widget-arrow {
        opacity: 1;
        transform: translateX(-4px);
    }
    .dash-widget--primary .dash-widget-icon { background: linear-gradient(135deg, #0162e8, #3d8bfd); }
    .dash-widget--success .dash-widget-icon { background: linear-gradient(135deg, #22c03c, #5dd879); }
    .dash-widget--info .dash-widget-icon { background: linear-gradient(135deg, #00b9ff, #5ed4ff); }
    .dash-widget--warning .dash-widget-icon { background: linear-gradient(135deg, #fbbc0b, #ffd24d); }
    .dash-widget--danger .dash-widget-icon { background: linear-gradient(135deg, #ee335e, #ff6b8a); }
    .dash-widget--purple .dash-widget-icon { background: linear-gradient(135deg, #7200c9, #a855f7); }
    .dash-widget--teal .dash-widget-icon { background: linear-gradient(135deg, #00cccc, #3de8e8); }
    .dash-widget--orange .dash-widget-icon { background: linear-gradient(135deg, #fd7e14, #ffa94d); }
    .dash-widget--dark .dash-widget-icon { background: linear-gradient(135deg, #3b4863, #5c6b8a); }
    .dash-section-title {
        font-weight: 800;
        font-size: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dash-section-title::before {
        content: '';
        width: 4px;
        height: 18px;
        border-radius: 4px;
        background: rgb(var(--primary-rgb));
    }
    .dash-alert-strip {
        border-radius: 14px;
        border: 1px solid rgba(var(--warning-rgb), 0.25);
        background: rgba(var(--warning-rgb), 0.08);
    }
    .dash-activity-item {
        padding: 12px 0;
        border-bottom: 1px dashed var(--default-border);
    }
    .dash-activity-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }
    .dash-welcome-card {
        border: 0;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.92) 0%, rgba(var(--primary-rgb), 0.75) 55%, rgba(114, 0, 201, 0.85) 100%);
        color: #fff;
    }
    .dash-welcome-card .text-muted {
        color: rgba(255, 255, 255, 0.82) !important;
    }
    @media (max-width: 575.98px) {
        .dash-widget {
            padding: 14px;
        }
        .dash-widget-icon {
            width: 46px;
            height: 46px;
            font-size: 1.2rem;
        }
        .dash-widget-body .dash-widget-count {
            font-size: 1.15rem;
        }
    }
</style>
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card dash-welcome-card">
                    <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h4 class="mb-1 text-white">مرحباً بعودتك، {{ auth()->user()->name ?? 'المدير' }}!</h4>
                            <p class="mb-0 text-muted">لوحة تحكم مركز الإدارة — نظرة سريعة على كل أقسام النظام.</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-white text-primary fs-12 px-3 py-2">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ now()->translatedFormat('l، d F Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($summary['unread_total'] > 0 || $pendingTestimonials > 0)
        <div class="alert dash-alert-strip d-flex flex-wrap align-items-center gap-2 mb-4" role="alert">
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

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card custom-card dash-summary-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="dash-summary-icon bg-primary-transparent text-primary">
                                <i class="bi bi-collection-fill"></i>
                            </span>
                            <div class="ms-3">
                                <p class="mb-0 text-muted fs-12">إجمالي المحتوى</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($summary['content_items']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card custom-card dash-summary-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="dash-summary-icon bg-warning-transparent text-warning">
                                <i class="bi bi-envelope-exclamation-fill"></i>
                            </span>
                            <div class="ms-3">
                                <p class="mb-0 text-muted fs-12">طلبات غير مقروءة</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($summary['unread_total']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card custom-card dash-summary-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="dash-summary-icon bg-danger-transparent text-danger">
                                <i class="bi bi-chat-square-quote-fill"></i>
                            </span>
                            <div class="ms-3">
                                <p class="mb-0 text-muted fs-12">آراء بانتظار الموافقة</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($summary['pending_testimonials']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card custom-card dash-summary-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <span class="dash-summary-icon bg-success-transparent text-success">
                                <i class="bi bi-mailbox2-flag"></i>
                            </span>
                            <div class="ms-3">
                                <p class="mb-0 text-muted fs-12">مشتركو النشرة النشطون</p>
                                <h3 class="mb-0 fw-bold">{{ number_format($summary['newsletter_active']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($widgetGroups as $group)
        <div class="mb-4">
            <h5 class="dash-section-title">{{ $group['title'] }}</h5>
            <div class="row g-3">
                @foreach($group['widgets'] as $widget)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <a href="{{ $widget['url'] }}" class="dash-widget {{ $widget['color'] }}">
                        <span class="dash-widget-icon">
                            <i class="bi {{ $widget['icon'] }}"></i>
                        </span>
                        <span class="dash-widget-body">
                            <h6>{{ $widget['title'] }}</h6>
                            @if(!is_null($widget['count']))
                                <p class="dash-widget-count">{{ number_format($widget['count']) }}</p>
                            @endif
                            @if($widget['badge'])
                                <span class="dash-widget-meta text-warning">{{ $widget['badge'] }}</span>
                            @elseif(is_null($widget['count']))
                                <span class="dash-widget-meta text-muted">{{ $widget['badge'] ?? 'فتح القسم' }}</span>
                            @else
                                <span class="dash-widget-meta text-muted">إدارة القسم</span>
                            @endif
                        </span>
                        <i class="bi bi-chevron-left dash-widget-arrow"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0"><i class="bi bi-envelope-open me-2 text-primary"></i>آخر رسائل التواصل</div>
                        <a href="{{ route('admin.contact-messages.index') }}" class="fs-12 text-primary">عرض الكل</a>
                    </div>
                    <div class="card-body">
                        @forelse($recentMessages as $message)
                        <div class="dash-activity-item">
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
                <div class="card custom-card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0"><i class="bi bi-calendar-event me-2 text-success"></i>آخر طلبات الاستشارة</div>
                        <a href="{{ route('admin.consultation-requests.index') }}" class="fs-12 text-primary">عرض الكل</a>
                    </div>
                    <div class="card-body">
                        @forelse($recentConsultations as $request)
                        <div class="dash-activity-item">
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
