@extends('admin.layouts.master')

@section('page-title')
إضافة شريك / عميل
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h4 class="mb-0">إضافة شريك / عميل</h4>
                <p class="mb-0 text-muted">إضافة شركة أو عميل يظهر في قسم شركاؤنا والعملاء</p>
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right-circle me-2"></i> العودة للقائمة
                </a>
            </div>
        </div>

        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.partners._form')
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i> حفظ</button>
            </div>
        </form>
    </div>
</div>
@endsection
