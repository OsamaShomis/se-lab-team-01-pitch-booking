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

    /* Bookings Grid & Cards */
    .bookings-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .booking-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.5rem 1.75rem;
        display: grid;
        grid-template-columns: 1fr auto auto;
        align-items: center;
        gap: 1.75rem;
        box-shadow: 0 2px 12px rgba(53, 76, 43, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .booking-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(53, 76, 43, 0.08);
        border-color: var(--color-surface-mint);
    }

    .card-main {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .card-title-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        text-decoration: none;
    }

    .ref-tag {
        font-family: 'Inter', monospace;
        font-size: 0.8rem;
        font-weight: 700;
        background: #F1F5F9;
        color: #475569;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        letter-spacing: 0.5px;
        border: 1px solid #E2E8F0;
    }

    .card-chips {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.85rem;
        font-size: 0.88rem;
        color: var(--color-text-body);
    }

    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #F8FAF6;
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
        border: 1px solid #EAEFE6;
    }

    .meta-chip .icon {
        color: var(--color-primary-medium);
    }

    /* Card Pricing Section */
    .card-pricing {
        text-align: left;
        padding: 0 1.25rem;
        border-left: 1px solid var(--color-border-light);
        border-right: 1px solid var(--color-border-light);
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 140px;
    }

    .price-caption {
        font-size: 0.78rem;
        color: var(--color-text-muted);
        font-weight: 600;
    }

    .price-num {
        font-size: 1.35rem;
        font-weight: 900;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    .price-currency {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-primary-medium);
        margin-right: 0.25rem;
    }

    /* Card Actions & Status */
    .card-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.65rem;
        min-width: 170px;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.9rem;
        border-radius: var(--radius-pill);
        font-size: 0.82rem;
        font-weight: 800;
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

    .btn-cancel-booking {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: #FEE2E2;
        color: #991B1B;
        border: 1.5px solid #FCA5A5;
        padding: 0.45rem 1rem;
        border-radius: var(--radius-btn);
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-cancel-booking:hover {
        background: #FCA5A5;
        color: #7F1D1D;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(185, 28, 28, 0.15);
    }

    .cancellation-hint {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .cancellation-hint.locked {
        color: #B91C1C;
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

    /* Responsive */
    @media (max-width: 900px) {
        .booking-card {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .card-pricing {
            text-align: right;
            padding: 0.75rem 0;
            border-left: none;
            border-right: none;
            border-top: 1px solid var(--color-border-light);
            border-bottom: 1px solid var(--color-border-light);
        }

        .card-actions {
            align-items: flex-start;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="bookings-page">

    <!-- Header Section -->
    <div class="bookings-header">
        <div class="header-text">
            <h1>
                <svg class="icon" style="width: 28px; height: 28px; color: var(--color-primary);" viewBox="0 0 24 24">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                    <line x1="16" x2="16" y1="2" y2="6"/>
                    <line x1="8" x2="8" y1="2" y2="6"/>
                    <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
                <span>سجل حجوزاتي والمواعيد</span>
            </h1>
            <p>إدارة مواعيد مبارياتك، التحقق من الحالات، والاستفادة من سياسة الإلغاء المرنة</p>
        </div>

        <div class="feature-badge">
            <svg class="icon" style="width: 1rem; height: 1rem; color: var(--color-primary);" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>ميزة FR-06: إلغاء واستعراض الحجوزات</span>
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

        <!-- Bookings List -->
        <div class="bookings-list" id="bookingsContainer">
            @foreach($bookings as $booking)
                @php
                    $slot = $booking->timeSlot;
                    $pitch = $slot?->pitch;
                    $canCancel = $booking->canBeCancelled();
                @endphp
                <div class="booking-card" data-status="{{ $booking->status }}">
                    <!-- Card Main Info -->
                    <div class="card-main">
                        <div class="card-title-row">
                            <span class="card-title">{{ $pitch?->name ?? 'ملعب رياضي' }}</span>
                            <span class="ref-tag" title="رمز الحجز المرجعي">{{ $booking->booking_reference }}</span>
                        </div>
                        <div class="card-chips">
                            <span class="meta-chip">
                                <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span>{{ $pitch?->location ?? 'صنعاء' }}</span>
                            </span>

                            <span class="meta-chip">
                                <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/>
                                    <line x1="8" x2="8" y1="2" y2="6"/>
                                    <line x1="3" x2="21" y1="10" y2="10"/>
                                </svg>
                                <span>{{ $slot?->date?->format('Y-m-d') }}</span>
                            </span>

                            <span class="meta-chip">
                                <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span>{{ substr($slot?->start_time ?? '', 0, 5) }} — {{ substr($slot?->end_time ?? '', 0, 5) }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Card Pricing -->
                    <div class="card-pricing">
                        <span class="price-caption">المبلغ الإجمالي</span>
                        <div class="price-num">
                            {{ number_format($booking->total_price, 0) }}
                            <span class="price-currency">ر.ي</span>
                        </div>
                    </div>

                    <!-- Card Actions & Status -->
                    <div class="card-actions">
                        @if($booking->status === 'confirmed')
                            <span class="badge-status badge-confirmed">
                                <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                                <span>حجز مؤكد</span>
                            </span>

                            @if($canCancel)
                                <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء الحجز رقم {{ $booking->booking_reference }}؟ سيتم إتاحة الفترة فوراً للآخرين.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-cancel-booking" title="إلغاء هذا الحجز وفق قاعدة BR-03">
                                        <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24">
                                            <line x1="18" x2="6" y1="6" y2="18"/>
                                            <line x1="6" x2="18" y1="6" y2="18"/>
                                        </svg>
                                        <span>إلغاء الحجز</span>
                                    </button>
                                </form>
                                <span class="cancellation-hint">
                                    <svg class="icon" style="width: 0.8rem; height: 0.8rem; color: var(--color-success);" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    <span>متاح للإلغاء (يتبقى > 2 ساعة)</span>
                                </span>
                            @else
                                <span class="cancellation-hint locked">
                                    <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    <span>مغلق للإلغاء (&lt; ساعتان)</span>
                                </span>
                            @endif

                        @elseif($booking->status === 'completed')
                            <span class="badge-status badge-completed">
                                <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <span>اكتملت المباراة</span>
                            </span>
                            <span class="cancellation-hint">
                                <span>تم إثبات الحضور والانتهاء</span>
                            </span>

                        @elseif($booking->status === 'cancelled')
                            <span class="badge-status badge-cancelled">
                                <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" x2="9" y1="9" y2="15"/>
                                    <line x1="9" x2="15" y1="9" y2="15"/>
                                </svg>
                                <span>تم الإلغاء</span>
                            </span>
                            <span class="cancellation-hint">
                                <span>ألغي وأتيحت الفترة مجدداً</span>
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
                        card.style.display = 'grid';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
