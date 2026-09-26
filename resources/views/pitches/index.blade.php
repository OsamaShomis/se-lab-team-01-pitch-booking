@extends('layouts.app')

@section('title', 'استعراض الملاعب الرياضية — كورة بلص')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary-dark); margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.6rem;">
        <svg class="icon" style="width: 1.75rem; height: 1.75rem; color: var(--color-primary-dark);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
            <path d="M2 12h20"/>
        </svg>
        <span>استعراض الملاعب المتاحة</span>
    </h1>
    <p style="color: var(--color-text-muted); font-size: 0.95rem;">
        أهلاً بك @auth <strong>{{ auth()->user()->name }}</strong> @endauth في منصة كورة بلص. تصفح الملاعب المعتمدة واحجز مباراتك بسهولة.
    </p>
</div>

<div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 3rem 2rem; text-align: center; box-shadow: var(--shadow-sm); max-width: 780px; margin: 0 auto;">
    <div style="width: 64px; height: 64px; border-radius: var(--radius-pill); background-color: var(--color-bg-main); color: var(--color-primary-dark); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; border: 1px solid var(--color-surface-mint);">
        <svg class="icon" style="width: 2rem; height: 2rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="18" height="18" x="3" y="3" rx="2"/>
            <circle cx="12" cy="12" r="3"/>
            <line x1="3" x2="21" y1="12" y2="12"/>
        </svg>
    </div>
    
    <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--color-primary-dark); margin-bottom: 0.65rem;">
        واجهة الملاعب جاهزة ومربوطة مع جدول الساعات
    </h2>
    
    <p style="color: var(--color-text-body); max-width: 580px; margin: 0 auto 1.75rem auto; font-size: 0.95rem; line-height: 1.7;">
        تم تسجيل دخولك بنجاح. سيتم في مهمة (FR-02) استعراض بطاقات الملاعب والفلاتر. يمكنك الآن الانتقال مباشرة لمعاينة وحجز جدول الفترات والساعات المتاحة (FR-03).
    </p>

    <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('pitches.slots', 1) }}" class="btn btn-primary">
            <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            عرض جدول الساعات المتاحة (FR-03)
        </a>
        <a href="{{ url('/') }}" class="btn btn-outline-light" style="color: var(--color-text-body); border-color: var(--color-border);">
            <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2 2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            العودة للرئيسية
        </a>
    </div>
</div>
@endsection
