@extends('admin.layouts.master')

@section('page-title')
تعديل فيديو
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">تعديل فيديو: {{ $video->title }}</h4>
                <p class="mb-0 text-muted">تحديث بيانات الفيديو</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right-circle me-2"></i>
                    العودة للفيديوهات
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
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>هناك بعض الأخطاء في البيانات المدخلة، يرجى المراجعة:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.videos._form')

            <div class="mt-3 d-flex justify-content-between">
                <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفيديو؟')" class="d-inline">
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
