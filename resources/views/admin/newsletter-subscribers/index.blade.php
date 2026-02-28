@extends('admin.layouts.master')

@section('page-title')
النشرة البريدية
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">المشتركون في النشرة البريدية</h4>
                <p class="mb-0 text-muted">إدارة اشتراكات النشرة البريدية</p>
            </div>
            <a href="{{ route('admin.newsletter-subscribers.export', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-download me-1"></i> تصدير CSV
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="avatar avatar-lg bg-primary-transparent text-primary rounded">
                                    <i class="bi bi-people fs-3"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">إجمالي المشتركين</h6>
                                <h4 class="mb-0">{{ $stats['total'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="avatar avatar-lg bg-success-transparent text-success rounded">
                                    <i class="bi bi-check-circle fs-3"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">نشط</h6>
                                <h4 class="mb-0">{{ $stats['active'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="avatar avatar-lg bg-info-transparent text-info rounded">
                                    <i class="bi bi-calendar-plus fs-3"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 text-muted">جدد هذا الشهر</h6>
                                <h4 class="mb-0">{{ $stats['this_month'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title">فلترة وبحث</div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">بحث بالبريد</label>
                            <input type="text" name="search" class="form-control" placeholder="البريد الإلكتروني..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-search me-1"></i> بحث
                            </button>
                            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة المشتركين ({{ $subscribers->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>البريد الإلكتروني</th>
                                <th>المصدر</th>
                                <th>تاريخ الاشتراك</th>
                                <th>الحالة</th>
                                <th width="100">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $subscriber)
                            <tr>
                                <td>{{ $loop->iteration + ($subscribers->currentPage() - 1) * $subscribers->perPage() }}</td>
                                <td><strong>{{ $subscriber->email }}</strong></td>
                                <td><span class="badge bg-primary-transparent">{{ \App\Models\NewsletterSubscriber::sourceLabel($subscriber->source ?? '') }}</span></td>
                                <td>{{ ($subscriber->subscribed_at ?? $subscriber->created_at)->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($subscriber->is_active)
                                        <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary-transparent text-secondary">ملغي</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المشترك؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-light" title="حذف">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-envelope display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا يوجد مشتركون في النشرة حالياً</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($subscribers->hasPages())
            <div class="card-footer">
                {{ $subscribers->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
