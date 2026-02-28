@extends('admin.layouts.master')

@section('page-title')
آراء الطلاب
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">آراء الطلاب</h4>
                <p class="mb-0 text-muted">إدارة آراء وتجارب الطلاب مع الدورات</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة رأي جديد
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
                            <input type="text" name="search" class="form-control" placeholder="ابحث باسم الطالب أو الكورس..." value="{{ request('search') }}">
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
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة آراء الطلاب ({{ $testimonials->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>الطالب</th>
                                <th>الكورس</th>
                                <th>التقييم</th>
                                <th>مميز</th>
                                <th>الحالة</th>
                                <th>الترتيب</th>
                                <th width="140">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                            <tr>
                                <td>{{ $loop->iteration + ($testimonials->currentPage() - 1) * $testimonials->perPage() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->student_name }}" class="me-2 rounded-circle" style="width:36px;height:36px;object-fit:cover">
                                        @else
                                            <div class="me-2 bg-primary-transparent rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px">
                                                <span class="fw-bold text-primary">{{ mb_substr($testimonial->student_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $testimonial->student_name }}</strong>
                                            @if($testimonial->student_title)
                                                <div class="text-muted small">{{ $testimonial->student_title }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $testimonial->course_name ?? '-' }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-muted"></i>
                                        @endif
                                    @endfor
                                </td>
                                <td>
                                    @if($testimonial->is_featured)
                                        <span class="badge bg-info-transparent text-info">مميز</span>
                                    @else
                                        <span class="badge bg-secondary-transparent text-secondary">عادي</span>
                                    @endif
                                </td>
                                <td>
                                    @if($testimonial->is_active)
                                        <span class="badge bg-success-transparent text-success">نشط</span>
                                    @else
                                        <span class="badge bg-danger-transparent text-danger">معطل</span>
                                    @endif
                                </td>
                                <td>{{ $testimonial->order }}</td>
                                <td>
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-primary-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الرأي؟')">
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
                                    <i class="bi bi-chat-square-quote display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا توجد آراء طلاب حالياً</p>
                                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>إضافة رأي جديد
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($testimonials->hasPages())
            <div class="card-footer">
                {{ $testimonials->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

