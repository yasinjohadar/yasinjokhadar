@extends('admin.layouts.master')

@section('page-title')
إضافة مشروع جديد
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div><h4 class="mb-0">إضافة مشروع جديد</h4></div>
            <div class="ms-auto">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
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

        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card custom-card mb-4">
                        <div class="card-header">
                            <div class="card-title">معلومات المشروع</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">التصنيف <span class="text-danger">*</span></label>
                                <select name="project_category_id" class="form-select @error('project_category_id') is-invalid @enderror" required>
                                    <option value="">اختر التصنيف</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('project_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">عنوان المشروع <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الرابط (Slug)</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="يُولد تلقائياً من العنوان إن تُرك فارغاً">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">وصف قصير</label>
                                <textarea name="short_description" rows="2" class="form-control">{{ old('short_description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الوصف التفصيلي</label>
                                <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">صورة المشروع</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">رابط عرض المشروع (Demo)</label>
                                    <input type="url" name="demo_url" class="form-control" value="{{ old('demo_url') }}" placeholder="https://...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">رابط الكود (GitHub)</label>
                                    <input type="url" name="code_url" class="form-control" value="{{ old('code_url') }}" placeholder="https://github.com/...">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">التقنيات المستخدمة (Tags)</label>
                                <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="مثال: React, Node.js, MongoDB">
                            </div>
                        </div>
                    </div>
                    @include('admin.projects._features')
                    @include('admin.projects._videos')
                    @include('admin.projects._gallery')
                </div>
                <div class="col-lg-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">مشروع نشط</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-save me-2"></i>حفظ المشروع
                            </button>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary w-100">إلغاء</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

