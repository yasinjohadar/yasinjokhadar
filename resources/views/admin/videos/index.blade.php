@extends('admin.layouts.master')

@section('page-title')
الفيديوهات
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">الفيديوهات</h4>
                <p class="mb-0 text-muted">إدارة فيديوهات القناة المعروضة في الموقع</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة فيديو
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
                            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة الفيديوهات ({{ $videos->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>العنوان</th>
                                <th>الرابط</th>
                                <th>المشاهدات</th>
                                <th>مميز</th>
                                <th>الحالة</th>
                                <th>الترتيب</th>
                                <th width="140">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos as $video)
                            <tr>
                                <td>{{ $loop->iteration + ($videos->currentPage() - 1) * $videos->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($video->thumbnail_url)
                                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="me-2 rounded" style="width:56px;height:32px;object-fit:cover">
                                        @endif
                                        <strong>{{ $video->title }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ $video->video_url }}" target="_blank" rel="noopener noreferrer" class="text-primary small">رابط</a>
                                </td>
                                <td>{{ number_format($video->views_count) }}</td>
                                <td>
                                    @if($video->is_featured)
                                        <span class="badge bg-info-transparent text-info">مميز</span>
                                    @else
                                        <span class="badge bg-secondary-transparent text-secondary">عادي</span>
                                    @endif
                                </td>
                                <td>
                                    @if($video->is_active)
                                        <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                        <span class="badge bg-danger-transparent text-danger">معطل</span>
                                    @endif
                                </td>
                                <td>{{ $video->order }}</td>
                                <td>
                                    <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-primary-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفيديو؟')">
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
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-play-circle display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا توجد فيديوهات حالياً</p>
                                    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>إضافة فيديو
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($videos->hasPages())
            <div class="card-footer">
                {{ $videos->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
