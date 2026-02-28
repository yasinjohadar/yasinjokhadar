@extends('admin.layouts.master')

@section('page-title')
تصنيفات المسيرة
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">تصنيفات المسيرة</h4>
                <p class="mb-0 text-muted">إدارة تصنيفات محطات الرحلة (التعليم الأكاديمي، المشوار المهني، الرحلة التدريبية...)</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.journey-categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة تصنيف
                </a>
                <a href="{{ route('admin.journey-milestones.index') }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-list-ul me-2"></i>
                    المحطات
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title">بحث</div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">بحث بالاسم</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث باسم التصنيف...">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search me-1"></i> بحث</button>
                            <a href="{{ route('admin.journey-categories.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة التصنيفات ({{ $categories->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>الاسم</th>
                            <th>الأيقونة</th>
                            <th>عدد المحطات</th>
                            <th>الترتيب</th>
                            <th>الحالة</th>
                            <th width="140">إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} me-2"></i>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $category->milestones()->count() }}</td>
                                <td>{{ $category->order }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary-transparent text-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.journey-categories.edit', $category) }}" class="btn btn-sm btn-primary-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.journey-categories.destroy', $category) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-light">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا توجد تصنيفات مسيرة بعد.</p>
                                    <a href="{{ route('admin.journey-categories.create') }}" class="btn btn-primary mt-2">إضافة تصنيف</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($categories->hasPages())
                <div class="card-footer">{{ $categories->links() }}</div>
            @endif
        </div>

    </div>
</div>
@endsection
