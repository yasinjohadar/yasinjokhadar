@extends('admin.layouts.master')

@section('page-title')
جميع الكورسات
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">جميع الكورسات</h4>
                <p class="mb-0 text-muted">إدارة الدورات التدريبية</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة كورس جديد
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
                <div class="card-title">فلترة وبحث</div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">بحث</label>
                            <input type="text" name="search" class="form-control" placeholder="ابحث بالعنوان..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
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
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة الكورسات ({{ $courses->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>العنوان</th>
                                <th>التصنيف</th>
                                <th>السعر</th>
                                <th>المدة</th>
                                <th>الحالة</th>
                                <th width="120">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration + ($courses->currentPage() - 1) * $courses->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($course->image)
                                        <img src="{{ route('course.image', ['filename' => basename($course->image)]) }}" alt="" class="me-2 rounded" style="width:40px;height:40px;object-fit:cover">
                                        @else
                                        <div class="me-2 bg-light rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px"><i class="bi bi-book text-muted"></i></div>
                                        @endif
                                        <strong>{{ Str::limit($course->title, 45) }}</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary-transparent">{{ $course->category->name ?? '-' }}</span></td>
                                <td>{{ number_format($course->price, 2) }} $</td>
                                <td>{{ $course->duration_hours ? $course->duration_hours . ' ساعة' : '-' }}</td>
                                <td>
                                    @if($course->is_active)
                                    <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                    <span class="badge bg-secondary-transparent text-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-primary-light"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-light"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا توجد كورسات</p>
                                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>إضافة كورس</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($courses->hasPages())
            <div class="card-footer">
                {{ $courses->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
