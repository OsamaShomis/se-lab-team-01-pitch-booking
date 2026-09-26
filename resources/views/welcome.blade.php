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
        <a href="{{ route('register', ['role' => 'player']) }}" class="btn btn-accent hero-btn">
            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>انضم كلاعب واحجز مباراتك</span>
        </a>
        <a href="{{ route('register', ['role' => 'owner']) }}" class="btn btn-outline-light hero-btn">
            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
            <span>سجّل منشأتك الرياضية معنا</span>
        </a>
    </div>
</section>

<!-- Features Highlights -->
<section class="features-grid">
    <a href="{{ route('pitches.index') }}" class="feature-card" style="text-decoration: none; color: inherit; display: block;">
        <div class="feature-icon-box">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" y2="16.65"/></svg>
        </div>
        <h3>استكشف أفضل الملاعب (FR-02)</h3>
        <p>تصفح قائمة الملاعب المعتمدة، واطلع على الأسعار، ونوع العشب، والموقع الجغرافي والخدمات المتاحة.</p>
        <span style="display: inline-block; margin-top: 0.85rem; font-weight: 700; color: var(--color-primary-dark); font-size: 0.85rem;">استعراض الملاعب ←</span>
    </a>

    <a href="{{ route('pitches.slots', 1) }}" class="feature-card" style="text-decoration: none; color: inherit; display: block;">
        <div class="feature-icon-box">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        </div>
        <h3>جدول الساعات المتاحة (FR-03)</h3>
        <p>اختر التاريخ والساعة الشاغرة وأكد حجزك فوراً دون الحاجة للمكالمات الهاتفية أو انتظار الرد.</p>
        <span style="display: inline-block; margin-top: 0.85rem; font-weight: 700; color: var(--color-primary-dark); font-size: 0.85rem;">عرض جدول الساعات ←</span>
    </a>

    <a href="{{ route('owner.dashboard') }}" class="feature-card" style="text-decoration: none; color: inherit; display: block; border-right: 4px solid var(--color-accent-soft);">
        <div class="feature-icon-box" style="background-color: #FEF3C7; color: #92400E;">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
        </div>
        <h3>لوحة تحكم صاحب الملعب (FR-05)</h3>
        <p>إدارة متكاملة لجدول المواعيد وساعات العمل، وتتبع الحجوزات اليومية وتأكيد الحضور وإلغاء المواعيد.</p>
        <span style="display: inline-block; margin-top: 0.85rem; font-weight: 700; color: #92400E; font-size: 0.85rem;">فتح لوحة التحكم ←</span>
    </a>

    <a href="{{ route('bookings.my') }}" class="feature-card" style="text-decoration: none; color: inherit; display: block; border-right: 4px solid var(--color-primary-medium);">
        <div class="feature-icon-box" style="background-color: #DCFCE7; color: #166534;">
            <svg class="icon" style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <h3>سجل حجوزاتي وإلغاء الحجز (FR-06)</h3>
        <p>متابعة وتفاصيل الحجوزات المؤكدة، وتطبيق سياسة الإلغاء المرنة وإلغاء الحجز قبل ساعتين (قاعدة BR-03).</p>
        <span style="display: inline-block; margin-top: 0.85rem; font-weight: 700; color: #166534; font-size: 0.85rem;">استعراض حجوزاتي ←</span>
    </a>
</section>
@endsection
