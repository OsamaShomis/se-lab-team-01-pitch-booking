@extends('layouts.app')

@section('title', 'استعراض الملاعب الرياضية — كورة بلص')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.5rem;">
        ⚽ استعراض الملاعب المتاحة
    </h1>
    <p style="color: var(--color-text-muted);">
        أهلاً بك @auth <strong>{{ auth()->user()->name }}</strong> @endauth في منصة كورة بلص. اختر ملعبك المفضل واحجز حصتك الآن.
    </p>
</div>

<div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 2rem; text-align: center; box-shadow: var(--shadow-sm);">
    <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">🏟️</span>
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 0.5rem;">
        واجهة الملاعب جاهزة للربط مع ميزة استعراض الملاعب (FR-02)
    </h3>
    <p style="color: var(--color-text-muted); max-width: 600px; margin: 0 auto 1.5rem auto;">
        تم تسجيل دخولك بنجاح بحساب لاعب. سيتم في الخطوة التالية (FR-02 / US-02) عرض بطاقات الملاعب الحقيقية وفلاتر البحث.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">العودة للرئيسية</a>
</div>
@endsection
