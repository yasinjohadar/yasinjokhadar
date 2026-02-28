@extends('admin.layouts.master')

@section('page-title')
الشركاء والعملاء
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">الشركاء والعملاء</h4>
                <p class="mb-0 text-muted">إدارة شركاء وعملاء المعرض في الموقع</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    إضافة شريك / عميل
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
            <strong><i class="bi bi-exclamation-triangle me-2"></i>هناك أخطاء في البيانات المدخلة:</strong>
            <ul class="mb-0 mt-2 list-unstyled">
                @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
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
                            <input type="text" name="search" class="form-control" placeholder="الاسم أو الوصف..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">النوع</label>
                            <select name="type" class="form-select">
                                <option value="">الكل</option>
                                @foreach(\App\Models\Partner::typesForSelect() as $value => $label)
                                    <option value="{{ $value }}" {{ request('type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">الكل</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">مميز</label>
                            <select name="featured" class="form-select">
                                <option value="">الكل</option>
                                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>مميز</option>
                                <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>غير مميز</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search me-1"></i> بحث</button>
                            <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">قائمة الشركاء والعملاء ({{ $partners->total() }})</div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>الشعار</th>
                                <th>الاسم</th>
                                <th>النوع</th>
                                <th>مميز</th>
                                <th>الحالة</th>
                                <th>الترتيب</th>
                                <th width="140">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partners as $p)
                            <tr>
                                <td>{{ $loop->iteration + ($partners->currentPage() - 1) * $partners->perPage() }}</td>
                                <td>
                                    <img src="{{ $p->logo_url }}" alt="{{ $p->name }}" class="rounded" style="width:48px;height:48px;object-fit:contain;background:#f5f5f5;">
                                </td>
                                <td><strong>{{ $p->name }}</strong></td>
                                <td><span class="badge bg-primary-transparent">{{ \App\Models\Partner::typeLabel($p->type) }}</span></td>
                                <td>
                                    @if($p->is_featured)<span class="badge bg-info-transparent text-info">مميز</span>
                                    @else<span class="badge bg-secondary-transparent text-secondary">—</span>@endif
                                </td>
                                <td>
                                    @if($p->is_active)<span class="badge bg-success-transparent text-success">نشط</span>
                                    @else<span class="badge bg-danger-transparent text-danger">معطل</span>@endif
                                </td>
                                <td>{{ $p->order }}</td>
                                <td>
                                    <a href="{{ route('admin.partners.edit', $p) }}" class="btn btn-sm btn-primary-light"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.partners.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger-light"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-people display-4 text-muted"></i>
                                    <p class="text-muted mt-3">لا يوجد شركاء أو عملاء حالياً</p>
                                    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>إضافة</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($partners->hasPages())
            <div class="card-footer">{{ $partners->links() }}</div>
            @endif
        </div>

    </div>
</div>
@endsection
