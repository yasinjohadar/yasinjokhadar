@extends('admin.layouts.master')

@section('page-title', 'إعدادات الموقع')

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h4 class="page-title fw-semibold fs-18 mb-0">إعدادات الموقع</h4>
            <p class="fw-normal text-muted fs-14 mb-0">إدارة معلومات التواصل وروابط السوشيال ميديا المعروضة في الموقع</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>
            <ul class="mb-0 list-unstyled">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.site.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- معلومات التواصل -->
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title"><i class="ri-phone-line me-2"></i>معلومات التواصل</div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">البريد الإلكتروني</label>
                    <div class="col-sm-10">
                        <input type="email" name="site_email" class="form-control @error('site_email') is-invalid @enderror"
                               value="{{ old('site_email', $settings['site_email'] ?? '') }}" placeholder="info@example.com">
                        @error('site_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">رقم الهاتف</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_phone" class="form-control @error('site_phone') is-invalid @enderror"
                               value="{{ old('site_phone', $settings['site_phone'] ?? '') }}" placeholder="+963 XXX XXX XXX">
                        @error('site_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">رقم الواتساب (لرابط wa.me)</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_whatsapp" class="form-control @error('site_whatsapp') is-invalid @enderror"
                               value="{{ old('site_whatsapp', $settings['site_whatsapp'] ?? '') }}" placeholder="963XXXXXXXXX (أرقام فقط أو مع +)">
                        <small class="text-muted">يُستخدم لزر واتساب في الموقع. مثال: 963912345678</small>
                        @error('site_whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">العنوان</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_address" class="form-control @error('site_address') is-invalid @enderror"
                               value="{{ old('site_address', $settings['site_address'] ?? '') }}" placeholder="سوريا">
                        @error('site_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-2 col-form-label">ساعات العمل</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_working_hours" class="form-control @error('site_working_hours') is-invalid @enderror"
                               value="{{ old('site_working_hours', $settings['site_working_hours'] ?? '') }}" placeholder="السبت - الخميس: 9:00 ص - 6:00 م">
                        @error('site_working_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- السوشيال ميديا -->
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="card-title"><i class="ri-share-line me-2"></i>السوشيال ميديا</div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">فيسبوك</label>
                    <div class="col-sm-10">
                        <input type="url" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                               value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/...">
                        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">يوتيوب</label>
                    <div class="col-sm-10">
                        <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror"
                               value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/...">
                        @error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">انستغرام</label>
                    <div class="col-sm-10">
                        <input type="url" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                               value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/...">
                        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">لينكد إن</label>
                    <div class="col-sm-10">
                        <input type="url" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror"
                               value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" placeholder="https://linkedin.com/...">
                        @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">جيت هاب</label>
                    <div class="col-sm-10">
                        <input type="url" name="github_url" class="form-control @error('github_url') is-invalid @enderror"
                               value="{{ old('github_url', $settings['github_url'] ?? '') }}" placeholder="https://github.com/...">
                        @error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-2 col-form-label">تليجرام</label>
                    <div class="col-sm-10">
                        <input type="url" name="telegram_url" class="form-control @error('telegram_url') is-invalid @enderror"
                               value="{{ old('telegram_url', $settings['telegram_url'] ?? '') }}" placeholder="https://t.me/...">
                        @error('telegram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary btn-wave">
                    <i class="ri-save-line me-1"></i> حفظ التغييرات
                </button>
            </div>
        </div>
    </form>
</div>
</div>
<!-- End::app-content -->
@stop
