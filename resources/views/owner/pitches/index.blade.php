@extends('layouts.app')

@section('title', 'إدارة ملاعبي — منصة كورة بلص')

@push('styles')
<style>
    /* Owner Pitches Hub Styles */
    .pitches-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
        margin-bottom: 2rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--color-border-light);
    }

    .pitches-title-group h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .pitches-title-group p {
        color: var(--color-text-muted);
        font-size: 0.95rem;
    }

    /* KPI Summary Cards */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2.25rem;
    }

    .metric-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 16px -4px rgba(53, 76, 43, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px -4px rgba(53, 76, 43, 0.1);
    }

    .metric-icon-box {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .metric-icon-olive {
        background-color: rgba(53, 76, 43, 0.1);
        color: var(--color-primary-dark);
    }

    .metric-icon-green {
        background-color: rgba(78, 101, 61, 0.1);
        color: var(--color-primary);
    }

    .metric-icon-tint {
        background-color: rgba(164, 177, 123, 0.2);
        color: var(--color-primary-dark);
    }

    .metric-icon-red {
        background-color: rgba(220, 38, 38, 0.1);
        color: #DC2626;
    }

    .metric-info h4 {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .metric-info .metric-num {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
        line-height: 1.1;
    }

    /* Pitches Grid */
    .pitches-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.75rem;
    }

    .pitch-admin-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: 0 4px 18px -4px rgba(53, 76, 43, 0.06);
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .pitch-admin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px -6px rgba(53, 76, 43, 0.12);
        border-color: var(--color-surface-mint);
    }

    .card-img-wrapper {
        position: relative;
        height: 190px;
        background-color: var(--color-primary-dark);
        overflow: hidden;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .pitch-admin-card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }

    .card-status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.35rem 0.75rem;
        border-radius: var(--radius-pill);
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        backdrop-filter: blur(8px);
    }

    .badge-active {
        background: rgba(21, 128, 61, 0.9);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .badge-inactive {
        background: rgba(100, 116, 139, 0.9);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .card-turf-tag {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.92);
        color: var(--color-primary-dark);
        padding: 0.3rem 0.7rem;
        border-radius: var(--radius-sm);
        font-size: 0.8rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .pitch-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
        gap: 0.75rem;
    }

    .pitch-title-row h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        line-height: 1.3;
    }

    .pitch-price-badge {
        background: #FDFEFC;
        border: 1px solid var(--color-surface-mint);
        padding: 0.35rem 0.65rem;
        border-radius: var(--radius-sm);
        text-align: center;
        white-space: nowrap;
    }

    .pitch-price-badge .price-val {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    .pitch-price-badge .price-curr {
        font-size: 0.7rem;
        color: var(--color-text-muted);
    }

    .pitch-location-text {
        color: var(--color-text-body);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 1.1rem;
    }

    .pitch-stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        padding: 0.85rem 1rem;
        background-color: var(--color-bg-main);
        border-radius: var(--radius-md);
        margin-bottom: 1.25rem;
        border: 1px solid var(--color-border-light);
    }

    .stat-mini-item {
        text-align: center;
    }

    .stat-mini-item .val {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    .stat-mini-item .lbl {
        font-size: 0.75rem;
        color: var(--color-text-muted);
    }

    .card-actions {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 0.5rem;
        margin-top: auto;
    }

    /* Empty state */
    .empty-pitches-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--color-card-bg);
        border-radius: var(--radius-card);
        border: 2px dashed var(--color-border-light);
    }

    .empty-pitches-icon {
        width: 72px;
        height: 72px;
        background-color: rgba(53, 76, 43, 0.08);
        color: var(--color-primary-dark);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
    }

    .empty-pitches-state h3 {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.5rem;
    }

    .empty-pitches-state p {
        color: var(--color-text-muted);
        max-width: 480px;
        margin: 0 auto 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="pitches-management-wrapper">

    <!-- Top Header & Action Buttons -->
    <div class="pitches-header">
        <div class="pitches-title-group">
            <h1>
                <svg class="svg-icon" style="width: 2rem; height: 2rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                إدارة ملاعبي ومنشآتي
            </h1>
            <p>استعرض ملاعبك المسجلة، عدّل المواصفات والأسعار، وتحكّم في المواعيد والفترات الزمنية بكل سهولة.</p>
        </div>
        <div class="header-actions" style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-light" style="color: var(--color-primary-dark); border-color: var(--color-border);">
                <svg class="svg-icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                لوحة الجدول اليومي
            </a>
            <a href="{{ route('owner.pitches.create') }}" class="btn btn-primary">
                <svg class="svg-icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                إضافة ملعب جديد
            </a>
        </div>
    </div>

    <!-- Metrics Summary Cards -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon-box metric-icon-olive">
                <svg class="svg-icon" style="width: 24px; height: 24px;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
            </div>
            <div class="metric-info">
                <h4>إجمالي الملاعب</h4>
                <div class="metric-num">{{ $totalPitches }}</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-box metric-icon-green">
                <svg class="svg-icon" style="width: 24px; height: 24px;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="metric-info">
                <h4>الملاعب النشطة</h4>
                <div class="metric-num">{{ $activePitches }}</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-box metric-icon-tint">
                <svg class="svg-icon" style="width: 24px; height: 24px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="metric-info">
                <h4>إجمالي الفترات المجهزة</h4>
                <div class="metric-num">{{ $totalSlots }}</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon-box metric-icon-red">
                <svg class="svg-icon" style="width: 24px; height: 24px;" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="metric-info">
                <h4>الحجوزات المثبتة</h4>
                <div class="metric-num">{{ $bookedSlots }}</div>
            </div>
        </div>
    </div>

    <!-- Pitches List Grid -->
    @if($pitches->count() > 0)
        <div class="pitches-cards-grid">
            @foreach($pitches as $pitch)
                <div class="pitch-admin-card">
                    <div class="card-img-wrapper">
                        <img src="{{ $pitch->image_url }}" alt="{{ $pitch->name }}" onerror="this.src='https://images.unsplash.com/photo-1529900240041-52c3ad58b021?auto=format&fit=crop&w=800&q=80'">
                        <span class="card-status-badge {{ $pitch->is_active ? 'badge-active' : 'badge-inactive' }}">
                            <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#fff;"></span>
                            {{ $pitch->is_active ? 'نشط ومتاح' : 'مغلق مؤقتاً' }}
                        </span>
                        <span class="card-turf-tag">{{ $pitch->turf_label }}</span>
                    </div>

                    <div class="card-body">
                        <div class="pitch-title-row">
                            <h3>{{ $pitch->name }}</h3>
                            <div class="pitch-price-badge">
                                <div class="price-val">{{ number_format($pitch->hourly_rate) }}</div>
                                <div class="price-curr">ريال / مباراة</div>
                            </div>
                        </div>

                        <div class="pitch-location-text">
                            <svg class="svg-icon" style="width: 1rem; height: 1rem; color: var(--color-primary-medium);" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>{{ $pitch->location }}</span>
                        </div>

                        <div class="pitch-stats-row">
                            <div class="stat-mini-item">
                                <div class="val">{{ $pitch->time_slots_count }}</div>
                                <div class="lbl">فترة مسجلة</div>
                            </div>
                            <div class="stat-mini-item">
                                <div class="val" style="color: #15803D;">{{ $pitch->booked_slots_count }}</div>
                                <div class="lbl">حجز مؤكد</div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('owner.pitches.show', $pitch) }}" class="btn btn-primary" style="padding: 0.45rem 0.85rem; font-size: 0.88rem;">
                                <svg class="svg-icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                إدارة المواعيد
                            </a>
                            <a href="{{ route('owner.pitches.edit', $pitch) }}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem; font-size: 0.88rem;" title="تعديل بيانات الملعب">
                                <svg class="svg-icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                تعديل
                            </a>
                            <a href="{{ route('pitches.slots', $pitch) }}" target="_blank" class="btn btn-accent" style="padding: 0.45rem 0.75rem; font-size: 0.88rem;" title="معاينة كلاعب">
                                <svg class="svg-icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-pitches-state">
            <div class="empty-pitches-icon">
                <svg class="svg-icon" style="width: 36px; height: 36px;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
            </div>
            <h3>لم تقم بإضافة أي ملعب بعد</h3>
            <p>ابدأ الآن بإضافة منشأتك وملعبك الرياضي، وحدد أسعار الفترات وسيقوم النظام بتهيئة جدول المواعيد تلقائياً لتستقبل حجوزات اللاعبين.</p>
            <a href="{{ route('owner.pitches.create') }}" class="btn btn-primary" style="padding: 0.75rem 1.75rem;">
                <svg class="svg-icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                إضافة أول ملعب لك الآن
            </a>
        </div>
    @endif

</div>
@endsection
