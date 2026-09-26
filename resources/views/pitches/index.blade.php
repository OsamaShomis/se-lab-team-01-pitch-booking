@extends('layouts.app')

@section('title', 'استعراض الملاعب الرياضية — كورة بلص')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.6rem;">
        <svg class="icon" style="width: 1.75rem; height: 1.75rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
        <span>استعراض الملاعب المتاحة</span>
    </h1>
    <p style="color: var(--color-text-muted); font-size: 0.92rem;">
        أهلاً بك @auth <strong>{{ auth()->user()->name }}</strong> @endauth في منصة كورة بلص. تصفح الملاعب المعتمدة واحجز مباراتك بسهولة.
    </p>
</div>

<div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 2.5rem 2rem; text-align: center; box-shadow: var(--shadow-sm);">
    <div style="width: 56px; height: 56px; border-radius: var(--radius-md); background-color: #F1F6EE; color: var(--color-primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
        <svg class="icon" style="width: 1.75rem; height: 1.75rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
    </div>
    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.5rem;">
        واجهة الملاعب جاهزة للربط مع ميزة استعراض الملاعب (FR-02)
    </h3>
    <p style="color: var(--color-text-muted); max-width: 580px; margin: 0 auto 1.5rem auto; font-size: 0.9rem;">
        تم تسجيل دخولك بنجاح بحساب لاعب. سيتم في المهمة التالية (FR-02 / US-02) عرض بطاقات الملاعب الحقيقية وفلاتر البحث والأسعار.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">العودة للرئيسية</a>
</div>
@endsection
