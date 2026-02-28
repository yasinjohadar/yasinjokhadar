@extends('admin.layouts.master')

@section('page-title')
تعديل شريك / عميل
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">تعديل: {{ $partner->name }}</h4>
                <p class="mb-0 text-muted">تحديث بيانات الشريك/العميل</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right-circle me-2"></i> العودة للقائمة
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.partners._form')
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i> حفظ التعديلات</button>
            </div>
        </form>
        <div class="mt-2">
            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger-light"><i class="bi bi-trash me-1"></i> حذف</button>
            </form>
        </div>
    </div>
</div>
@endsection
