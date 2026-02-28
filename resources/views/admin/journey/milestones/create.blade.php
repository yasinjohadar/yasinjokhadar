@extends('admin.layouts.master')
@section('page-title') إضافة محطة مسيرة @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div><h4 class="mb-0">إضافة محطة جديدة</h4></div>
            <div class="ms-auto">
                <a href="{{ route('admin.journey-milestones.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-2"></i>رجوع
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($categories->isEmpty())
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                يجب أن توجد تصنيفات مسيرة أولاً. <a href="{{ route('admin.journey-categories.create') }}">اضغط هنا لإضافة تصنيف</a>
            </div>
        @else
        <form action="{{ route('admin.journey-milestones.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card custom-card mb-4">
                        <div class="card-header">
                            <div class="card-title">معلومات المحطة</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">التصنيف <span class="text-danger">*</span></label>
                                    <select name="journey_category_id" class="form-select @error('journey_category_id') is-invalid @enderror" required>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('journey_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('journey_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">السنة <span class="text-danger">*</span></label>
                                    <input type="text" name="year" class="form-control @error('year') is-invalid @enderror"
                                           value="{{ old('year') }}" required placeholder="مثال: 2016">
                                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">العنوان <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" required placeholder="مثال: بداية المشوار">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الوصف</label>
                                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="تفاصيل المحطة...">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">محطة نشطة</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-save me-2"></i>حفظ المحطة
                            </button>
                            <a href="{{ route('admin.journey-milestones.index') }}" class="btn btn-secondary w-100">إلغاء</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection
