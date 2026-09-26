@extends('layouts.app')

@section('title', 'لوحة تحكم صاحب المنشأة — كورة بلص')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.6rem;">
                <svg class="icon" style="width: 1.75rem; height: 1.75rem;" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span>لوحة تحكم صاحب المنشأة</span>
            </h1>
            <p style="color: var(--color-text-muted); font-size: 0.92rem;">
                مرحباً بك @auth <strong>{{ auth()->user()->name }}</strong> @endauth. تابع حجوزات ملاعبيك وجدول المواعيد الشاغرة.
            </p>
        </div>
        <span style="background-color: #FEF3C7; color: #92400E; font-weight: 700; padding: 0.35rem 0.9rem; border-radius: 20px; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 0.4rem;">
            <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
            <span>صاحب منشأة رياضية</span>
        </span>
    </div>
</div>

<div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 2.5rem 2rem; text-align: center; box-shadow: var(--shadow-sm);">
    <div style="width: 56px; height: 56px; border-radius: var(--radius-md); background-color: #F1F6EE; color: var(--color-primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
        <svg class="icon" style="width: 1.75rem; height: 1.75rem;" viewBox="0 0 24 24"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
    </div>
    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.5rem;">
        لوحة تحكم إدارة الملاعب (FR-05) جاهزة
    </h3>
    <p style="color: var(--color-text-muted); max-width: 580px; margin: 0 auto 1.5rem auto; font-size: 0.9rem;">
        تم تسجيل دخولك بنجاح بصلاحية صاحب منشأة. سيتم في المهمة (FR-05 / US-05) عرض إحصائيات الملاعب وتأكيد الحجوزات وإدارة الساعات الشاغرة.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">العودة للرئيسية</a>
</div>
@endsection
