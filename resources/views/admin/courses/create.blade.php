@extends('admin.layouts.master')

@section('page-title')
إضافة كورس جديد
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div><h4 class="mb-0">إضافة كورس جديد</h4></div>
            <div class="ms-auto"><a href="{{ route('admin.courses.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-2"></i>رجوع</a></div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(!isset($course) || !$course)
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card custom-card mb-4">
                            <div class="card-header"><div class="card-title">معلومات الكورس</div></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">التصنيف <span class="text-danger">*</span></label>
                                    <select name="course_category_id" class="form-select @error('course_category_id') is-invalid @enderror" required>
                                        <option value="">اختر التصنيف</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('course_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">العنوان <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
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
                                    <label class="form-label">الوصف الكامل</label>
                                    <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">صورة الكورس</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">السعر ($) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" required>
                                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">السعر القديم ($)</label>
                                        <input type="number" step="0.01" name="old_price" class="form-control" value="{{ old('old_price') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">المدة (ساعات)</label>
                                        <input type="number" name="duration_hours" class="form-control" value="{{ old('duration_hours') }}" min="0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">عدد الدروس</label>
                                        <input type="number" name="lessons_count" class="form-control" value="{{ old('lessons_count') }}" min="0">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">عدد الطلاب</label>
                                        <input type="number" name="students_count" class="form-control" value="{{ old('students_count', 0) }}" min="0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">المستوى</label>
                                        <input type="text" name="level" class="form-control" value="{{ old('level') }}" placeholder="مبتدئ / متوسط / متقدم">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اللغة</label>
                                        <input type="text" name="language" class="form-control" value="{{ old('language') }}" placeholder="العربية">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">الشارة (Badge)</label>
                                    <input type="text" name="badge" class="form-control" value="{{ old('badge') }}" placeholder="مثل: الأكثر مبيعاً، جديد">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">عنوان SEO</label>
                                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">وصف SEO</label>
                                    <textarea name="meta_description" rows="2" class="form-control">{{ old('meta_description') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">لمحة سريعة عن الدورة</label>
                                    <textarea name="highlights" rows="3" class="form-control" placeholder="اكتب كل نقطة في سطر منفصل">{{ old('highlights') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ماذا ستتعلم في هذه الدورة</label>
                                    <textarea name="learn_items" rows="4" class="form-control" placeholder="اكتب كل نقطة في سطر منفصل">{{ old('learn_items') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">المتطلبات المسبقة</label>
                                    <textarea name="requirements" rows="3" class="form-control" placeholder="اكتب كل متطلب في سطر منفصل">{{ old('requirements') }}</textarea>
                                </div>
                            </div>
                        </div>
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
                                    <label class="form-check-label" for="is_active">كورس نشط</label>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mb-2"><i class="bi bi-save me-2"></i>حفظ الكورس</button>
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary w-100">إلغاء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="row">
                <div class="col-lg-8">
                    @include('admin.courses.partials.curriculum', ['course' => $course])
                </div>
                <div class="col-lg-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <h6 class="mb-2">معلومات الكورس الأساسية</h6>
                            <p class="mb-1"><strong>العنوان:</strong> {{ $course->title }}</p>
                            <p class="mb-1"><strong>التصنيف:</strong> {{ optional($course->category)->name }}</p>
                            <p class="mb-3 text-muted small">يمكنك تعديل بيانات الكورس من صفحة التعديل إن لزم.</p>
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-pencil me-1"></i> تعديل بيانات الكورس
                            </a>
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary w-100">رجوع إلى جميع الكورسات</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@include('admin.courses.partials.curriculum-script')
