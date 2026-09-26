@extends('layouts.app')

@section('title', 'لوحة تحكم صاحب الملعب — كورة بلص')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: gap: 1rem;">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--color-primary); margin-bottom: 0.5rem;">
                🏟️ لوحة تحكم صاحب الملعب
            </h1>
            <p style="color: var(--color-text-muted);">
                مرحباً بك @auth <strong>{{ auth()->user()->name }}</strong> @endauth. تابع حجوزات ملاعبيك وجدول المواعيد الشاغرة.
            </p>
        </div>
        <span style="background-color: #FEF3C7; color: #92400E; font-weight: 700; padding: 0.4rem 1rem; border-radius: 30px; font-size: 0.85rem;">
            صلاحية: صاحب منشأة رياضية
        </span>
    </div>
</div>

<div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 2.5rem 2rem; text-align: center; box-shadow: var(--shadow-sm);">
    <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">📊</span>
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 0.5rem;">
        لوحة تحكم إدارة الملاعب (FR-05) جاهزة
    </h3>
    <p style="color: var(--color-text-muted); max-width: 600px; margin: 0 auto 1.5rem auto;">
        تم تسجيل دخولك بنجاح بصلاحية صاحب ملعب. ستتمكن هنا من إدارة أوقات الملعب وتأكيد وإلغاء الحجوزات.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">العودة للرئيسية</a>
</div>
@endsection
