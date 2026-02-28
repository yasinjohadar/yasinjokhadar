@extends('admin.layouts.master')

@section('page-title')
تعديل رأي طالب
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">تعديل رأي: {{ $testimonial->student_name }}</h4>
                <p class="mb-0 text-muted">تحديث بيانات رأي الطالب</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right-circle me-2"></i>
                    العودة لآراء الطلاب
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
            <i class="bi bi-exclamation-triangle me-2"></i>هناك بعض الأخطاء في البيانات المدخلة، يرجى المراجعة.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.testimonials._form')

            <div class="mt-3 d-flex justify-content-between">
                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الرأي؟')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-light">
                        <i class="bi bi-trash me-1"></i> حذف
                    </button>
                </form>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

