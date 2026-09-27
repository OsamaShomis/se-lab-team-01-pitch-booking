@extends('layouts.app')

@section('title', 'حجوزاتي — منصة كورة بلص (KooraPlus)')

@push('styles')
<style>
    /* ==========================================================================
       My Bookings (FR-06) Styling — Pitch Natural Olive Theme
       ========================================================================== */
    .bookings-page {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    /* Page Header */
    .bookings-header {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 20px -4px rgba(53, 76, 43, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }

    .header-text h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .header-text p {
        color: var(--color-text-body);
        font-size: 0.95rem;
    }

    .feature-badge {
        background: #F1F6EE;
        border: 1px solid var(--color-surface-mint);
        color: var(--color-primary-dark);
        padding: 0.45rem 0.95rem;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Cancellation Policy Card (BR-03) */
    .policy-banner {
        background: linear-gradient(135deg, #F8FAF6 0%, #EEF4EA 100%);
        border: 1.5px solid var(--color-surface-mint);
        border-radius: var(--radius-card);
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        box-shadow: 0 2px 10px rgba(53, 76, 43, 0.04);
    }

    .policy-icon-wrapper {
        background: var(--color-primary-dark);
        color: #ffffff;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(53, 76, 43, 0.2);
    }

    .policy-content h3 {
        font-size: 1rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .policy-content p {
        font-size: 0.9rem;
        color: var(--color-primary);
        line-height: 1.6;
        margin: 0;
    }

    .policy-tag {
        background: var(--color-surface-tint);
        color: var(--color-primary-dark);
        font-size: 0.75rem;
        font-weight: 800;
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #ECEFE8;
        padding: 0.35rem;
        border-radius: 12px;
        width: fit-content;
        flex-wrap: wrap;
    }

    .tab-btn {
        background: transparent;
        border: none;
        padding: 0.55rem 1.25rem;
        border-radius: 9px;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--color-text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-family: inherit;
    }

    .tab-btn:hover {
        color: var(--color-primary-dark);
    }

    .tab-btn.active {
        background: #ffffff;
        color: var(--color-primary-dark);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .tab-count {
        background: rgba(53, 76, 43, 0.1);
        color: var(--color-primary-dark);
        font-size: 0.75rem;
        font-weight: 800;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
    }

    .tab-btn.active .tab-count {
        background: var(--color-primary-dark);
        color: #ffffff;
    }

    /* Bookings Grid & Modern Cards */
    .bookings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
    }

    .booking-card {
        background: var(--color-card-bg);
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-card);
        padding: 1.4rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.25s ease;
        position: relative;
    }

    .booking-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(53, 76, 43, 0.12);
        border-color: var(--color-primary-medium);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .pitch-header-info {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .pitch-icon-badge {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        background: #F1F6EE;
        border: 1px solid var(--color-surface-mint);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary-dark);
        flex-shrink: 0;
    }

    .card-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.2rem;
        line-height: 1.3;
    }

    .ref-chip {
        font-family: 'Inter', monospace;
        font-size: 0.78rem;
        font-weight: 700;
        background: #F1F5F9;
        color: #475569;
        padding: 0.15rem 0.55rem;
        border-radius: 6px;
        border: 1px solid #E2E8F0;
        display: inline-block;
    }

    .card-mid-specs {
        background: var(--color-bg-main);
        border: 1px solid #EAEFE6;
        border-radius: var(--radius-sm);
        padding: 0.85rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.88rem;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--color-text-body);
    }

    .spec-item .icon {
        color: var(--color-primary);
        width: 1rem;
        height: 1rem;
        flex-shrink: 0;
    }

    .card-bottom-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px dashed var(--color-border);
        gap: 0.75rem;
    }

    .card-price-block {
        display: flex;
        flex-direction: column;
    }

    .price-caption {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        font-weight: 600;
    }

    .price-num {
        font-size: 1.25rem;
        font-weight: 900;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    .price-currency {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--color-primary-medium);
        margin-right: 0.2rem;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.8rem;
        border-radius: var(--radius-pill);
        font-size: 0.8rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .badge-confirmed {
        background-color: #EBF5FF;
        color: #1E40AF;
        border: 1px solid #BFDBFE;
    }

    .badge-completed {
        background-color: var(--color-success-bg);
        color: var(--color-success);
        border: 1px solid #86EFAC;
    }

    .badge-cancelled {
        background-color: var(--color-slot-booked-bg);
        color: var(--color-slot-booked-text);
        border: 1px solid var(--color-slot-booked-border);
    }

    .card-actions-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-details {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        background: #F1F6EE;
        color: var(--color-primary-dark);
        border: 1px solid var(--color-surface-mint);
        padding: 0.45rem 0.9rem;
        border-radius: var(--radius-btn);
        font-size: 0.84rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
        flex: 1;
    }

    .btn-details:hover {
        background: var(--color-primary-dark);
        color: #ffffff;
        border-color: var(--color-primary-dark);
    }

    .btn-cancel-booking {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        background: #FEE2E2;
        color: #991B1B;
        border: 1px solid #FCA5A5;
        padding: 0.45rem 0.85rem;
        border-radius: var(--radius-btn);
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-cancel-booking:hover {
        background: #FCA5A5;
        color: #7F1D1D;
    }

    .cancellation-hint {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.25rem;
    }

    .cancellation-hint.locked {
        color: #B91C1C;
        font-weight: 700;
    }

    /* Details Modal Dialog */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(15, 30, 18, 0.75);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .modal-overlay.open {
        display: flex;
        opacity: 1;
    }

    .modal-box {
        background: #FFFFFF;
        border-radius: var(--radius-card);
        width: 100%;
        max-width: 490px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        border: 1px solid var(--color-border-light);
        display: flex;
        flex-direction: column;
    }

    .modal-header-olive {
        background: linear-gradient(135deg, var(--color-primary-dark) 0%, #24351d 100%);
        color: #FFFFFF;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top-left-radius: var(--radius-card);
        border-top-right-radius: var(--radius-card);
    }

    .modal-header-title {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .modal-close-btn {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #FFFFFF;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .modal-ref-card {
        background: #F8FAF6;
        border: 1px solid var(--color-surface-mint);
        border-radius: var(--radius-sm);
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .modal-table td {
        padding: 0.55rem 0.6rem;
        border-bottom: 1px solid var(--color-border);
    }

    .modal-table tr:last-child td {
        border-bottom: none;
    }

    .modal-label {
        color: var(--color-text-muted);
        font-weight: 600;
        width: 35%;
    }

    .modal-val {
        color: var(--color-primary-dark);
        font-weight: 700;
    }

    /* Empty State */
    .empty-card {
        background: var(--color-card-bg);
        border: 1.5px dashed var(--color-surface-mint);
        border-radius: var(--radius-card);
        padding: 3.5rem 2rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .empty-icon-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #F1F6EE;
        color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
    }

    .empty-card h3 {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--color-primary-dark);
    }

    .empty-card p {
        color: var(--color-text-muted);
        max-width: 450px;
        line-height: 1.6;
        font-size: 0.95rem;
    }
</style>
@endpush

@section('content')
<div class="bookings-page">

    <!-- Header Section -->
    <div class="bookings-header">
        <div class="header-text">
            <h1>
                <svg class="icon" style="width: 26px; height: 26px; color: var(--color-primary);" viewBox="0 0 24 24">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                    <line x1="16" x2="16" y1="2" y2="6"/>
                    <line x1="8" x2="8" y1="2" y2="6"/>
                    <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
                <span>سجل حجوزاتي والمواعيد</span>
            </h1>
            <p>إدارة مواعيد مبارياتك، معاينة تفاصيل الحجز، والاستفادة من سياسة الإلغاء المرنة</p>
        </div>

        <div class="feature-badge">
            <svg class="icon" style="width: 1rem; height: 1rem; color: var(--color-primary);" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>ميزة FR-06: حجوزاتي وإلغاء الحجز</span>
        </div>
    </div>

    <!-- Cancellation Policy Notice (BR-03) -->
    <div class="policy-banner">
        <div class="policy-icon-wrapper">
            <svg class="icon" style="width: 22px; height: 22px;" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" x2="12" y1="16" y2="12"/>
                <line x1="12" x2="12.01" y1="8" y2="8"/>
            </svg>
        </div>
        <div class="policy-content">
            <h3>
                <span>سياسة وقواعد الإلغاء المعتمدة</span>
                <span class="policy-tag">قاعدة العمل BR-03</span>
            </h3>
            <p>
                يحق للاعب إلغاء الحجز واسترجاع الموعد بحرية كاملة، بشرط أن يتم تقديم طلب الإلغاء قبل موعد بداية الفترة بـ <strong>ساعتين على الأقل (2 hours)</strong>. عند الإلغاء الناجح، يتم فتح الفترة فوراً في جدول الساعات لإتاحتها للفرق الأخرى.
            </p>
        </div>
    </div>

    @if($bookings->isEmpty())
        <!-- Empty State -->
        <div class="empty-card">
            <div class="empty-icon-circle">
                <svg class="icon" style="width: 36px; height: 36px;" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m4.93 4.93 4.24 4.24"/>
                    <path d="m14.83 9.17 4.24-4.24"/>
                    <path d="m14.83 14.83 4.24 4.24"/>
                    <path d="m9.17 14.83-4.24 4.24"/>
                    <circle cx="12" cy="12" r="4"/>
                </svg>
            </div>
            <h3>لا توجد لديك أي حجوزات حتى الآن</h3>
            <p>اختر ملعبك المفضل واحجز ساعتك الرياضية المناسبة بكل سهولة وموثوقية.</p>
            <a href="{{ route('pitches.index') }}" class="btn btn-primary" style="margin-top: 0.5rem;">
                <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24">
                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                    <circle cx="12" cy="12" r="3"/>
                    <line x1="3" x2="21" y1="12" y2="12"/>
                </svg>
                <span>تصفح الملاعب والساعات المتاحة</span>
            </a>
        </div>
    @else
        <!-- Filter Tabs -->
        @php
            $confirmedCount = $bookings->where('status', 'confirmed')->count();
            $completedCount = $bookings->where('status', 'completed')->count();
            $cancelledCount = $bookings->where('status', 'cancelled')->count();
        @endphp
        <div class="filter-tabs">
            <button type="button" class="tab-btn active" data-filter="all">
                <span>كافة الحجوزات</span>
                <span class="tab-count">{{ $bookings->count() }}</span>
            </button>
            <button type="button" class="tab-btn" data-filter="confirmed">
                <span>المؤكدة</span>
                <span class="tab-count">{{ $confirmedCount }}</span>
            </button>
            <button type="button" class="tab-btn" data-filter="completed">
                <span>المكتملة</span>
                <span class="tab-count">{{ $completedCount }}</span>
            </button>
            <button type="button" class="tab-btn" data-filter="cancelled">
                <span>الملغاة</span>
                <span class="tab-count">{{ $cancelledCount }}</span>
            </button>
        </div>

        <!-- Bookings Cards Grid -->
        <div class="bookings-grid" id="bookingsContainer">
            @foreach($bookings as $booking)
                @php
                    $slot = $booking->timeSlot;
                    $pitch = $slot?->pitch;
                    $canCancel = $booking->canBeCancelled();
                    
                    // Duration calculation
                    $startT = substr($slot?->start_time ?? '00:00', 0, 5);
                    $endT = substr($slot?->end_time ?? '00:00', 0, 5);
                    $durationText = '90 دقيقة (ساعة ونصف)';
                    if ($slot && $slot->start_time && $slot->end_time) {
                        try {
                            $diffM = \Carbon\Carbon::parse($slot->start_time)->diffInMinutes(\Carbon\Carbon::parse($slot->end_time));
                            $durationText = $diffM . ' دقيقة';
                        } catch (\Exception $e) {}
                    }
                @endphp
                <div class="booking-card" 
                     data-status="{{ $booking->status }}"
                     data-id="{{ $booking->id }}"
                     data-reference="{{ $booking->booking_reference }}"
                     data-pitch="{{ $pitch?->name ?? 'ملعب رياضي' }}"
                     data-location="{{ $pitch?->location ?? 'صنعاء' }}"
                     data-turf="{{ $pitch?->turf_type === 'natural' ? 'عشب طبيعي' : ($pitch?->turf_type === 'hybrid' ? 'صالة هجينة' : 'عشب صناعي') }}"
                     data-phone="{{ $pitch?->contact_phone ?? '—' }}"
                     data-date="{{ $slot?->date?->format('Y-m-d') }}"
                     data-time="{{ $startT }} — {{ $endT }}"
                     data-duration="{{ $durationText }}"
                     data-price="{{ number_format($booking->total_price, 0) }} ر.ي"
                     data-captain="{{ $booking->user?->name ?? auth()->user()->name }}"
                     data-captain-phone="{{ $booking->user?->phone ?? auth()->user()->phone ?? '—' }}"
                     data-notes="{{ $booking->notes ?? 'لا توجد ملاحظات إضافية' }}"
                     data-status-text="{{ $booking->status === 'confirmed' ? 'حجز مؤكد' : ($booking->status === 'completed' ? 'اكتملت المباراة' : 'تم الإلغاء') }}"
                     data-status-class="{{ $booking->status }}"
                     data-can-cancel="{{ $canCancel ? '1' : '0' }}"
                     data-cancel-url="{{ route('bookings.cancel', $booking->id) }}">
                    
                    <!-- Card Top Header -->
                    <div class="card-top">
                        <div class="pitch-header-info">
                            <div class="pitch-icon-badge">
                                <svg class="icon" style="width: 1.35rem; height: 1.35rem;" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="m4.93 4.93 4.24 4.24"/>
                                    <path d="m14.83 9.17 4.24-4.24"/>
                                    <path d="m14.83 14.83 4.24 4.24"/>
                                    <path d="m9.17 14.83-4.24 4.24"/>
                                    <circle cx="12" cy="12" r="4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="card-title">{{ $pitch?->name ?? 'ملعب رياضي' }}</h3>
                                <span class="ref-chip">{{ $booking->booking_reference }}</span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        @if($booking->status === 'confirmed')
                            <span class="badge-status badge-confirmed">
                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                <span>حجز مؤكد</span>
                            </span>
                        @elseif($booking->status === 'completed')
                            <span class="badge-status badge-completed">
                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>مكتمل</span>
                            </span>
                        @else
                            <span class="badge-status badge-cancelled">
                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <span>ملغي</span>
                            </span>
                        @endif
                    </div>

                    <!-- Card Mid Specs -->
                    <div class="card-mid-specs">
                        <div class="spec-item">
                            <svg class="icon" style="width: 1rem; height: 1rem; flex-shrink: 0;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            <span>التاريخ: <strong>{{ $slot?->date?->format('Y-m-d') }}</strong></span>
                        </div>
                        <div class="spec-item">
                            <svg class="icon" style="width: 1rem; height: 1rem; flex-shrink: 0;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>التوقيت: <strong>{{ $startT }} — {{ $endT }}</strong> ({{ $durationText }})</span>
                        </div>
                        <div class="spec-item">
                            <svg class="icon" style="width: 1rem; height: 1rem; flex-shrink: 0;" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span style="font-size: 0.82rem;">{{ $pitch?->location ?? 'صنعاء' }}</span>
                        </div>
                    </div>

                    <!-- Card Bottom / Pricing & Actions -->
                    <div>
                        <div class="card-bottom-row">
                            <div class="card-price-block">
                                <span class="price-caption">إجمالي المبلغ (كاش)</span>
                                <div class="price-num">
                                    {{ number_format($booking->total_price, 0) }}
                                    <span class="price-currency">ر.ي</span>
                                </div>
                            </div>

                            <button type="button" class="btn-details" onclick="openBookingDetails(this.closest('.booking-card'))">
                                <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/></svg>
                                <span>تفاصيل الحجز</span>
                            </button>
                        </div>

                        <!-- Cancellation Quick Row (if applicable) -->
                        @if($booking->status === 'confirmed')
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.65rem; padding-top: 0.5rem; border-top: 1px solid var(--color-border-light);">
                                @if($canCancel)
                                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء الحجز رقم {{ $booking->booking_reference }}؟ سيتم إتاحة الفترة فوراً للآخرين.');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cancel-booking" title="إلغاء هذا الحجز وفق قاعدة BR-03">
                                            <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                                            <span>إلغاء الحجز</span>
                                        </button>
                                    </form>
                                    <span class="cancellation-hint" style="margin: 0;">
                                        <svg class="icon" style="width: 0.8rem; height: 0.8rem; color: var(--color-success);" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                        <span>متاح للإلغاء (&gt; ساعتان)</span>
                                    </span>
                                @else
                                    <span class="cancellation-hint locked" style="margin: 0;">
                                        <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        <span>مغلق للإلغاء (&lt; ساعتان)</span>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>

<!-- Interactive Booking Details Modal -->
<div id="bookingDetailsModal" class="modal-overlay" onclick="handleModalOverlayClick(event)">
    <div class="modal-box">
        <!-- Modal Olive Header -->
        <div class="modal-header-olive">
            <div class="modal-header-title">
                <svg class="icon" style="width: 1.25rem; height: 1.25rem; color: var(--color-surface-tint);" viewBox="0 0 24 24">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                    <line x1="16" x2="16" y1="2" y2="6"/>
                    <line x1="8" x2="8" y1="2" y2="6"/>
                    <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
                <span>تفاصيل الحجز الرياضي</span>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeBookingModal()" title="إغلاق">
                <svg class="icon" style="width: 1.1rem; height: 1.1rem;" viewBox="0 0 24 24"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <div class="modal-body">
            <!-- Reference Code Box with Copy Action -->
            <div class="modal-ref-card">
                <div>
                    <div style="font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600;">الرمز المرجعي للحجز:</div>
                    <div id="m_reference" style="font-family: 'Inter', monospace; font-size: 1.15rem; font-weight: 800; color: var(--color-primary-dark); letter-spacing: 0.5px;">KP-0000-0000</div>
                </div>
                <button type="button" class="btn btn-outline-light" onclick="copyModalReference()" style="color: var(--color-primary-dark); border-color: var(--color-surface-mint); font-size: 0.8rem; padding: 0.35rem 0.75rem; min-height: 32px;">
                    <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    <span id="m_copy_text">نسخ الرمز</span>
                </button>
            </div>

            <!-- Booking Details Table -->
            <table class="modal-table">
                <tbody>
                    <tr>
                        <td class="modal-label">اسم الملعب:</td>
                        <td class="modal-val" id="m_pitch">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">الموقع والمدينة:</td>
                        <td class="modal-val" id="m_location">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">نوع الأرضية:</td>
                        <td class="modal-val" id="m_turf">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">تاريخ الموعد:</td>
                        <td class="modal-val" id="m_date">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">توقيت المباراة:</td>
                        <td class="modal-val" id="m_time">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">مدة المباراة:</td>
                        <td class="modal-val" id="m_duration">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">كابتن الفريق:</td>
                        <td class="modal-val" id="m_captain">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">هاتف التواصل:</td>
                        <td class="modal-val" id="m_phone">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">إجمالي المبلغ:</td>
                        <td class="modal-val" id="m_price" style="color: var(--color-primary-dark); font-size: 1.1rem; font-weight: 800;">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">طريقة الدفع:</td>
                        <td class="modal-val" style="color: #92400E; font-size: 0.82rem;">نقداً (كاش) في مقر الملعب عند الحضور قبل انطلاق المباراة</td>
                    </tr>
                    <tr>
                        <td class="modal-label">ملاحظات الحجز:</td>
                        <td class="modal-val" id="m_notes" style="font-weight: 500; font-size: 0.85rem; color: var(--color-text-body);">—</td>
                    </tr>
                    <tr>
                        <td class="modal-label">حالة الحجز:</td>
                        <td class="modal-val">
                            <span id="m_status_badge" class="badge-status">—</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal Action Buttons -->
            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 0.5rem; align-items: center;">
                <div id="m_cancel_container"></div>
                <button type="button" class="btn btn-outline-light" onclick="closeBookingModal()" style="color: var(--color-text-body); border-color: var(--color-border); font-size: 0.88rem; padding: 0.45rem 1.25rem;">
                    إغلاق النافذة
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tab Filtering
        const tabs = document.querySelectorAll('.tab-btn');
        const cards = document.querySelectorAll('.booking-card');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                cards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    if (filter === 'all' || status === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBookingModal();
            }
        });
    });

    function openBookingDetails(card) {
        if (!card) return;

        document.getElementById('m_reference').innerText = card.getAttribute('data-reference');
        document.getElementById('m_pitch').innerText = card.getAttribute('data-pitch');
        document.getElementById('m_location').innerText = card.getAttribute('data-location');
        document.getElementById('m_turf').innerText = card.getAttribute('data-turf');
        document.getElementById('m_date').innerText = card.getAttribute('data-date');
        document.getElementById('m_time').innerText = card.getAttribute('data-time');
        document.getElementById('m_duration').innerText = card.getAttribute('data-duration');
        document.getElementById('m_captain').innerText = card.getAttribute('data-captain');
        document.getElementById('m_phone').innerText = card.getAttribute('data-captain-phone');
        document.getElementById('m_price').innerText = card.getAttribute('data-price');
        document.getElementById('m_notes').innerText = card.getAttribute('data-notes');

        // Status badge
        const statusBadge = document.getElementById('m_status_badge');
        const statusClass = card.getAttribute('data-status-class');
        statusBadge.className = 'badge-status badge-' + statusClass;
        statusBadge.innerText = card.getAttribute('data-status-text');

        // Cancellation action in modal
        const cancelContainer = document.getElementById('m_cancel_container');
        cancelContainer.innerHTML = '';
        const canCancel = card.getAttribute('data-can-cancel') === '1';
        const cancelUrl = card.getAttribute('data-cancel-url');
        const ref = card.getAttribute('data-reference');

        if (statusClass === 'confirmed' && canCancel && cancelUrl) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            cancelContainer.innerHTML = `
                <form method="POST" action="${cancelUrl}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء الحجز رقم ${ref}؟ سيتم إتاحة الفترة فوراً للآخرين.');" style="margin:0;">
                    <input type="hidden" name="_token" value="${token}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn-cancel-booking" style="padding: 0.45rem 1rem;">
                        <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                        <span>إلغاء هذا الحجز الآن</span>
                    </button>
                </form>
            `;
        }

        const modal = document.getElementById('bookingDetailsModal');
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingDetailsModal');
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    function handleModalOverlayClick(e) {
        if (e.target.id === 'bookingDetailsModal') {
            closeBookingModal();
        }
    }

    function copyModalReference() {
        const ref = document.getElementById('m_reference').innerText;
        navigator.clipboard.writeText(ref).then(() => {
            const copyText = document.getElementById('m_copy_text');
            const original = copyText.innerText;
            copyText.innerText = 'تم النسخ!';
            setTimeout(() => {
                copyText.innerText = original;
            }, 2000);
        });
    }
</script>
@endpush

