@extends('frontend.layouts.master')

@section('title', 'الشركات والعملاء | ياسين جوخدار')
@section('description', 'الشركات والعملاء — تعرف على من تعامل معهم ياسين جوخدار من شركات وعملاء مع عبارات شكر وتقدير.')

@section('content')
    <!-- ============ PAGE BANNER ============ -->
    <section class="page-banner page-banner-clients">
        <div class="page-banner-overlay"></div>
        <div class="container position-relative">
            <div class="page-banner-content animate-on-scroll">
                <div class="page-banner-icon"><i class="fas fa-handshake"></i></div>
                <h1 class="page-banner-title">الشركات <span>والعملاء</span></h1>
                <p class="page-banner-desc">شكراً لكل من وثق بي — شركات وعملاء كرام تعاملت معهم بامتنان واحترام</p>
                <nav class="page-banner-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <span class="page-banner-sep">/</span>
                    <span>الشركات والعملاء</span>
                </nav>
            </div>
        </div>
        <div class="page-banner-shape"></div>
    </section>

    <!-- ============ INTRO ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="clients-intro text-center mx-auto animate-on-scroll" style="max-width: 720px;">
                <span class="section-badge">امتنان</span>
                <h2 class="mb-3">ثقة غالية نقدّرها</h2>
                <p class="text-secondary mb-0">كل شركة وكل عميل تعاملت معه كان جزءاً من رحلتي — أقدّر الثقة والتعاون المثمر، وأضع هنا كلمة شكر وعرفان لهم.</p>
            </div>
        </div>
    </section>

    <!-- ============ CLIENTS GRID ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                @forelse($partners as $partner)
                <div class="col-lg-4 col-md-6">
                    <div class="glass-panel client-card animate-on-scroll">
                        <div class="client-card-logo">
                            <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" width="80" height="80" loading="lazy">
                        </div>
                        <span class="client-card-type">{{ \App\Models\Partner::typeLabel($partner->type) }}</span>
                        <h3 class="client-card-name">{{ $partner->name }}</h3>
                        @if($partner->description)
                        <p class="client-card-desc">{{ $partner->description }}</p>
                        @endif
                        @if($partner->quote)
                        <blockquote class="client-card-quote">"{{ $partner->quote }}"</blockquote>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-handshake text-muted" style="font-size:3rem;"></i>
                    <p class="text-muted mt-3">لا يوجد شركاء أو عملاء معروضون حالياً.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ============ CLOSING MESSAGE ============ -->
    <section class="section-padding">
        <div class="container">
            <div class="glass-panel clients-closing text-center py-5 px-4 animate-on-scroll">
                <i class="fas fa-heart mb-3" style="font-size: 2.5rem; color: var(--clr-primary);"></i>
                <h3 class="mb-2">شكراً لكم</h3>
                <p class="text-secondary mb-0 mx-auto" style="max-width: 560px;">كل اسم في هذه الصفحة يمثّل ثقة غالية وذكرى تعاون نقدّرها. نتمنى لكم التوفيق ونبقى في خدمتكم.</p>
            </div>
        </div>
    </section>
@endsection
