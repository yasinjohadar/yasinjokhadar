@extends('admin.layouts.master')

@section('page-title')
إضافة فيديو
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">إضافة فيديو</h4>
                <p class="mb-0 text-muted">إضافة فيديو جديد يظهر في صفحة الفيديوهات والموقع</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right-circle me-2"></i>
                    العودة للفيديوهات
                </a>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>هناك بعض الأخطاء في البيانات المدخلة، يرجى المراجعة.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.videos._form')

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    حفظ الفيديو
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
