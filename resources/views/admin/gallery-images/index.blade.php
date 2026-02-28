@extends('admin.layouts.master')

@section('page-title')
معرض الصور
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">معرض الصور</h4>
                <p class="mb-0 text-muted">إدارة صور المعرض المعروضة في الموقع</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة صورة
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>حدثت أخطاء في التحقق من البيانات.
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
                        <div class="col-md-4">
                            <label class="form-label">بحث</label>
                            <input type="text" name="search" class="form-control" placeholder="ابحث بالعنوان أو الوصف..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">مميز في الصفحة الرئيسية</label>
                            <select name="featured" class="form-select">
                                <option value="">الكل</option>
                                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>مميز</option>
                                <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>غير مميز</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-search me-1"></i> بحث
                            </button>
                            <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة الصور ({{ $images->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>معاينة</th>
                                <th>العنوان</th>
                                <th>مميز</th>
                                <th>الحالة</th>
                                <th>الترتيب</th>
                                <th width="140">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($images as $img)
                            <tr>
                                <td>{{ $loop->iteration + ($images->currentPage() - 1) * $images->perPage() }}</td>
                                <td>
                                    @if($img->image_url)
                                        <img src="{{ $img->image_url }}" alt="{{ $img->title }}" class="rounded" style="width:56px;height:42px;object-fit:cover">
                                    @else
                                        —
                                    @endif
                                </td>
                                <td><strong>{{ $img->title }}</strong></td>
                                <td>
                                    @if($img->is_featured)
                                        <span class="badge bg-info-transparent text-info">مميز</span>
                                    @else
                                        <span class="badge bg-secondary-transparent text-secondary">عادي</span>
                                    @endif
                                </td>
                                <td>
                                    @if($img->is_active)
                                        <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                        <span class="badge bg-danger-transparent text-danger">معطل</span>
                                    @endif
                                </td>
                                <td>{{ $img->order }}</td>
                                <td>
                                    <a href="{{ route('admin.gallery-images.edit', $img) }}" class="btn btn-sm btn-primary-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery-images.destroy', $img) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟')">
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
                                    <i class="bi bi-images display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا توجد صور في المعرض حالياً</p>
                                    <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>إضافة صورة
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($images->hasPages())
            <div class="card-footer">
                {{ $images->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
