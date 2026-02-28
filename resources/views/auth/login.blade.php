@extends('frontend.layouts.master')

@section('title', 'تسجيل الدخول | ياسين جوخدار')
@section('description', 'تسجيل الدخول إلى لوحة التحكم - ياسين جوخدار')

@section('content')
<section class="section-padding auth-page-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6 col-xl-5">
                <div class="auth-page-inner text-center">
                    <a href="{{ route('home') }}" class="auth-logo-link d-inline-block mb-4">
                        <img src="{{ $fa }}/images/logo.png" alt="ياسين جوخدار" width="56" height="56" class="auth-logo rounded-circle">
                        <h1 class="auth-title mt-3 mb-0">تسجيل الدخول</h1>
                    </a>

                    <div class="glass-panel auth-card">
                        @if (session('status'))
                            <div class="alert alert-success mb-3" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="auth-form">
                            @csrf

                            <div class="auth-form-group mb-3">
                                <label for="email" class="auth-label">البريد الإلكتروني</label>
                                <input id="email" type="email" name="email" class="auth-input form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com">
                                @if ($errors->get('email'))
                                    <div class="auth-error text-start mt-1">
                                        @foreach ((array) $errors->get('email') as $message)
                                            <small>{{ $message }}</small>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="auth-form-group mb-3">
                                <label for="password" class="auth-label">كلمة المرور</label>
                                <input id="password" type="password" name="password" class="auth-input form-control" required autocomplete="current-password" placeholder="••••••••">
                                @if ($errors->get('password'))
                                    <div class="auth-error text-start mt-1">
                                        @foreach ((array) $errors->get('password') as $message)
                                            <small>{{ $message }}</small>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="auth-form-group auth-remember mb-3 text-start">
                                <label for="remember_me" class="auth-remember-label">
                                    <input id="remember_me" type="checkbox" name="remember" class="auth-checkbox">
                                    <span>تذكرني</span>
                                </label>
                            </div>

                            <div class="auth-form-actions d-flex flex-wrap align-items-center justify-content-between gap-2">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="auth-forgot-link">نسيت كلمة المرور؟</a>
                                @endif
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
