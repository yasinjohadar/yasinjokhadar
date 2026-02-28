@extends('admin.layouts.master')

@section('page-title')
إضافة صورة للمعرض
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">إضافة صورة للمعرض</h4>
                <p class="mb-0 text-muted">إضافة صورة جديدة تظهر في المعرض والموقع</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.gallery-images.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right-circle me-2"></i>
                    العودة للمعرض
                </a>
            </div>
        </div>

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

        <form action="{{ route('admin.gallery-images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.gallery-images._form')

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>
                    حفظ الصورة
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
