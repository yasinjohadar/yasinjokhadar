@extends('admin.layouts.master')

@section('page-title')
محطات المسيرة
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">محطات المسيرة</h4>
                <p class="mb-0 text-muted">إدارة محطات الرحلة المعروضة في صفحة حول المدرب</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.journey-milestones.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة محطة
                </a>
                <a href="{{ route('admin.journey-categories.index') }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-folder me-2"></i>
                    التصنيفات
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title">فلترة وبحث</div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">بحث</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="العنوان أو الوصف أو السنة...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">التصنيف</label>
                            <select name="category" class="form-select">
                                <option value="">الكل</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search me-1"></i> بحث</button>
                            <a href="{{ route('admin.journey-milestones.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة المحطات ({{ $milestones->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>السنة</th>
                            <th>العنوان</th>
                            <th>التصنيف</th>
                            <th>الترتيب</th>
                            <th>الحالة</th>
                            <th width="140">إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($milestones as $m)
                            <tr>
                                <td>{{ $loop->iteration + ($milestones->currentPage() - 1) * $milestones->perPage() }}</td>
                                <td><strong>{{ $m->year }}</strong></td>
                                <td>{{ Str::limit($m->title, 50) }}</td>
                                <td>
                                    <span class="badge bg-primary-transparent text-primary">{{ $m->category->name }}</span>
                                </td>
                                <td>{{ $m->order }}</td>
                                <td>
                                    @if($m->is_active)
                                        <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary-transparent text-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.journey-milestones.edit', $m) }}" class="btn btn-sm btn-primary-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.journey-milestones.destroy', $m) }}"
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
                                    <p class="text-muted mt-3">لا توجد محطات مسيرة بعد.</p>
                                    <a href="{{ route('admin.journey-milestones.create') }}" class="btn btn-primary mt-2">إضافة محطة</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($milestones->hasPages())
                <div class="card-footer">{{ $milestones->links() }}</div>
            @endif
        </div>

    </div>
</div>
@endsection
