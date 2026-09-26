@extends('layouts.app')

@section('title', 'الرئيسية — منصة كورة بلص لحجز الملاعب الرياضية')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        border-radius: var(--radius-lg);
        color: #FFFFFF;
        padding: 4rem 2.5rem;
        text-align: center;
        margin-bottom: 3rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .hero-badge {
        display: inline-block;
        background-color: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.35rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: #FEF08A;
    }

    .hero h1 {
        font-size: 2.8rem;
        font-weight: 900;
        line-height: 1.25;
        margin-bottom: 1rem;
        letter-spacing: -1px;
    }

    .hero p {
        font-size: 1.15rem;
        color: #E2E8F0;
        max-width: 680px;
        margin: 0 auto 2.25rem auto;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.25rem;
        flex-wrap: wrap;
    }

    .hero-btn {
        padding: 0.85rem 1.85rem;
        font-size: 1.05rem;
        border-radius: var(--radius-md);
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.75rem;
        margin-bottom: 3rem;
    }

    .feature-card {
        background-color: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 2rem 1.75rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-secondary);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: inline-block;
    }

    .feature-card h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-primary);
        margin-bottom: 0.5rem;
    }

    .feature-card p {
        font-size: 0.95rem;
        color: var(--color-text-muted);
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .hero {
            padding: 2.5rem 1.5rem;
        }
        .hero h1 {
            font-size: 2rem;
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
    <span class="hero-badge">⚽ المنصة الأولى لإدارة وحجز الملاعب الرياضية</span>
    <h1>ملعبك المفضل بانتظارك.. احجز مباراتك الآن بضغطة زر!</h1>
    <p>تربط منصة كورة بلص بين عشاق كرة القدم وأصحاب الملاعب الرياضية في تجربة حجز رقمية فورية وسلسة وموثوقة.</p>

    <div class="hero-actions">
        <a href="{{ route('register', ['role' => 'player']) }}" class="btn btn-accent hero-btn">
            <span>انضم كلاعب واحجز مباراتك ⚽</span>
        </a>
        <a href="{{ route('register', ['role' => 'owner']) }}" class="btn btn-outline-light hero-btn">
            <span>سجّل ملعبك معنا كصاحب منشأة 🏟️</span>
        </a>
    </div>
</section>

<!-- Features Highlights -->
<section class="features-grid">
    <div class="feature-card">
        <span class="feature-icon">🔍</span>
        <h3>استكشف أفضل الملاعب</h3>
        <p>تصفح قائمة الملاعب المعتمدة، واطلع على الأسعار، ونوع العشب، والموقع الجغرافي والخدمات المتاحة.</p>
    </div>

    <div class="feature-card">
        <span class="feature-icon">⚡</span>
        <h3>حجز لحظي وتأكيد فوري</h3>
        <p>اختر التاريخ والساعة الشاغرة وأكد حجزك فوراً دون الحاجة للمكالمات الهاتفية أو انتظار الرد.</p>
    </div>

    <div class="feature-card">
        <span class="feature-icon">📊</span>
        <h3>لوحة تحكم لأصحاب الملاعب</h3>
        <p>إدارة متكاملة لجدول المواعيد وساعات العمل، وتتبع الحجوزات اليومية وإلغاء المواعيد بمرونة تامة.</p>
    </div>
</section>
@endsection
