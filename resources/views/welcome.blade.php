@extends('layouts.app')

@section('title', 'الرئيسية — منصة كورة بلص لحجز الملاعب الرياضية')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        border-radius: var(--radius-lg);
        color: #FFFFFF;
        padding: 3.5rem 2.5rem;
        text-align: center;
        margin-bottom: 2.5rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background-color: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 0.3rem 0.85rem;
        border-radius: 30px;
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: #FEF08A;
    }

    .hero h1 {
        font-size: 2.4rem;
        font-weight: 900;
        line-height: 1.3;
        margin-bottom: 0.85rem;
        letter-spacing: -0.5px;
    }

    .hero p {
        font-size: 1.05rem;
        color: #E2E8F0;
        max-width: 650px;
        margin: 0 auto 2rem auto;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-btn {
        padding: 0.75rem 1.65rem;
        font-size: 0.98rem;
        border-radius: var(--radius-md);
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .feature-card {
        background-color: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 1.75rem 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-secondary);
    }

    .feature-icon-box {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-md);
        background-color: #F1F6EE;
        color: var(--color-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .feature-card h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--color-primary);
        margin-bottom: 0.4rem;
    }

    .feature-card p {
        font-size: 0.88rem;
        color: var(--color-text-muted);
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .hero {
            padding: 2.5rem 1.5rem;
        }
        .hero h1 {
            font-size: 1.85rem;
        }
        .hero-actions {
            flex-direction: column;
            width: 100%;
        }
        .hero-btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero">
    <span class="hero-badge">
        <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <span>المنصة الرياضية الذكية لحجز وإدارة الملاعب</span>
    </span>
    <h1>ملعبك المفضل بانتظارك.. احجز مباراتك الآن بضغطة زر</h1>
    <p>تربط منصة كورة بلص بين عشاق كرة القدم وأصحاب الملاعب في تجربة رقمية فورية وسلسة وموثوقة.</p>

    <div class="hero-actions">
        <a href="{{ route('pitches.index') }}" class="btn btn-accent hero-btn" style="background-color: var(--color-surface-mint); color: var(--color-primary-dark); font-weight: 800;">
            <svg class="icon" style="width: 1.15rem; height: 1.15rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="m4.93 4.93 4.24 4.24"/>
                <path d="m14.83 9.17 4.24-4.24"/>
                <path d="m14.83 14.83 4.24 4.24"/>
                <path d="m9.17 14.83-4.24 4.24"/>
                <circle cx="12" cy="12" r="4"/>
            </svg>
            <span>استعراض وحجز الملاعب المتاحة</span>
        </a>
        <a href="{{ route('register', ['role' => 'player']) }}" class="btn btn-outline-light hero-btn">
            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>إنشاء حساب لاعب</span>
        </a>
        <a href="{{ route('register', ['role' => 'owner']) }}" class="btn btn-outline-light hero-btn" style="border-style: dashed; opacity: 0.9;">
            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
            <span>تسجيل منشأة رياضية</span>
        </a>
    </div>
</section>

{{-- Featured Pitches Showcase --}}
@if(isset($featuredPitches) && $featuredPitches->isNotEmpty())
<section style="margin-bottom: 2.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.25rem;">
        <div>
            <h2 style="font-size: 1.4rem; font-weight: 800; color: var(--color-primary-dark); margin: 0 0 0.3rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <svg class="icon" style="width: 1.3rem; height: 1.3rem; color: var(--color-primary-emerald);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m4.93 4.93 4.24 4.24"/>
                    <path d="m14.83 9.17 4.24-4.24"/>
                </svg>
                <span>ملاعب مميزة متاحة للحجز اليوم</span>
            </h2>
            <p style="color: var(--color-text-muted); font-size: 0.9rem; margin: 0;">اختر من الملاعب المعتمدة وانتقل مباشرة لجدول المواعيد</p>
        </div>
        <a href="{{ route('pitches.index') }}" style="font-size: 0.875rem; font-weight: 700; color: var(--color-primary-dark); text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
            <span>عرض كافة الملاعب ({{ \App\Models\Pitch::where('is_active', true)->count() }})</span>
            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.25rem;">
        @foreach($featuredPitches as $fPitch)
            <div style="background-color: var(--color-card-bg); border: 1px solid var(--color-border); border-radius: var(--radius-card); padding: 1.25rem; display: flex; flex-direction: column; justify-content: space-between; box-shadow: var(--shadow-sm); transition: transform 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <span style="font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: var(--radius-pill); background-color: var(--color-surface-mint); color: var(--color-primary-dark);">
                            @if($fPitch->turf_type === 'natural') عشب طبيعي @elseif($fPitch->turf_type === 'hybrid') صالة هجينة @else عشب صناعي @endif
                        </span>
                        <span style="font-size: 0.95rem; font-weight: 800; color: var(--color-primary-dark);">
                            {{ number_format($fPitch->hourly_rate) }} <small style="font-size: 0.75rem; font-weight: 600; color: var(--color-text-muted);">ر.ي/ساعة</small>
                        </span>
                    </div>
                    <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--color-text-title); margin: 0 0 0.35rem 0;">
                        {{ $fPitch->name }}
                    </h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-muted); margin: 0 0 1rem 0; line-height: 1.4;">
                        {{ $fPitch->location }}
                    </p>
                </div>
                <div style="display: flex; gap: 0.5rem; border-top: 1px solid var(--color-border); padding-top: 0.85rem;">
                    <a href="{{ route('pitches.slots', $fPitch->id) }}" class="btn btn-primary" style="flex: 1; justify-content: center; font-size: 0.825rem; padding: 0.5rem 0.75rem;">
                        حجز الساعات (FR-03)
                    </a>
                    <a href="{{ route('pitches.show', $fPitch->id) }}" class="btn btn-outline-light" style="justify-content: center; font-size: 0.825rem; padding: 0.5rem 0.75rem; color: var(--color-text-body); border-color: var(--color-border);">
                        تفاصيل
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- Features Highlights -->
<section class="features-grid">
    <div class="feature-card">
        <div class="feature-icon-box">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" x2="16.65"/></svg>
        </div>
        <h3>استكشف أفضل الملاعب</h3>
        <p>تصفح قائمة الملاعب المعتمدة، واطلع على الأسعار، ونوع العشب، والموقع الجغرافي والخدمات المتاحة.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-box">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        </div>
        <h3>حجز لحظي وتأكيد فوري</h3>
        <p>اختر التاريخ والساعة الشاغرة وأكد حجزك فوراً دون الحاجة للمكالمات الهاتفية أو انتظار الرد.</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-box">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" x2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
        </div>
        <h3>لوحة تحكم لأصحاب المنشآت</h3>
        <p>إدارة متكاملة لجدول المواعيد وساعات العمل، وتتبع الحجوزات اليومية وإلغاء المواعيد بمرونة تامة.</p>
    </div>
</section>
@endsection
