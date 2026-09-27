@extends('layouts.app')

@section('title', 'جدول الفترات المتاحة - ' . $pitch->name . ' | كورة بلص')

@push('styles')
<style>
    /* Pitch Header Card per Design-System Section 5.1 */
    .pitch-header {
        background: var(--color-card-bg);
        border-radius: var(--radius-card);
        padding: 1.75rem 2rem;
        box-shadow: 0 4px 20px -4px rgba(53, 76, 43, 0.08);
        border: 1px solid var(--color-border-light);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .pitch-title-area h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.6rem;
        line-height: 1.2;
    }

    .pitch-meta {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        flex-wrap: wrap;
        color: var(--color-text-body);
        font-size: 0.95rem;
    }

    .pitch-meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    /* Turf Badge per Section 2.A & 5.1 */
    .turf-badge {
        background-color: var(--color-surface-mint);
        color: var(--color-primary-dark);
        padding: 0.35rem 0.85rem;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 0.85rem;
        border: 1px solid var(--color-primary-medium);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .pitch-rate {
        text-align: left;
        background: #fdfefc;
        border: 1.5px dashed var(--color-surface-mint);
        padding: 0.75rem 1.25rem;
        border-radius: var(--radius-btn);
    }

    .rate-label {
        font-size: 0.85rem;
        color: var(--color-text-body);
        display: block;
        margin-bottom: 0.2rem;
    }

    .rate-value {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    /* Date Selection Section per Section 4 (8-Point Grid) */
    .section-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-title-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .date-nav-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .date-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 95px;
        min-height: 64px; /* Touch target >= 48px */
        padding: 0.75rem 1rem;
        background: var(--color-card-bg);
        border: 1.5px solid var(--color-border-light);
        border-radius: var(--radius-btn);
        text-decoration: none;
        color: var(--color-text-dark);
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .date-pill:hover {
        border-color: var(--color-accent-soft);
        transform: translateY(-2px);
    }

    /* Selected Date Pill per Section 2.B */
    .date-pill.active {
        background: var(--color-primary-dark);
        border-color: var(--color-primary-dark);
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(53, 76, 43, 0.25);
    }

    .pill-day {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0.15rem;
    }

    .pill-date {
        font-size: 1.1rem;
        font-weight: 800;
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    .custom-date-picker {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-btn);
        padding: 0.65rem 1rem;
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--color-text-dark);
    }

    .custom-date-picker input {
        border: 1px solid var(--color-border-light);
        border-radius: 6px;
        padding: 0.35rem 0.5rem;
        font-family: 'Inter', 'Cairo', sans-serif;
        font-size: 0.95rem;
        color: var(--color-text-dark);
        background: var(--color-bg-main);
        cursor: pointer;
    }

    /* Counters Bar */
    .counters-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        flex-wrap: wrap;
    }

    .counter-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: var(--radius-pill);
    }

    .counter-available {
        background: #f0fdf4;
        color: var(--color-primary-dark);
        border: 1px solid var(--color-surface-mint);
    }

    .counter-booked {
        background: var(--color-slot-booked-bg);
        color: var(--color-slot-booked-text);
        border: 1px solid var(--color-slot-booked-border);
    }

    /* Slots Grid per Section 2.B & 5.2 */
    .slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 1.25rem;
    }

    /* Slot Card Component */
    .slot-card {
        background: var(--color-card-bg);
        border-radius: var(--radius-card);
        padding: 1.4rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    /* Available Slot State per Section 2.B */
    .slot-card.available {
        background-color: var(--color-slot-avail-bg);
        border: 1.5px solid var(--color-slot-avail-border);
    }

    .slot-card.available:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(53, 76, 43, 0.15);
        border-color: var(--color-primary);
    }

    /* Booked Slot State per Section 2.B */
    .slot-card.booked {
        background-color: var(--color-slot-booked-bg);
        border: 1.5px solid var(--color-slot-booked-border);
        opacity: 0.9;
    }

    /* Past Slot State per Section 2.B */
    .slot-card.past {
        background-color: var(--color-slot-past-bg);
        border: 1.5px solid var(--color-slot-past-border);
        opacity: 0.65;
    }

    .slot-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .slot-status-pill {
        font-size: 0.8rem;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-pill);
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .pill-available {
        background: var(--color-surface-mint);
        color: var(--color-primary-dark);
    }

    .pill-booked {
        background: #fee2e2;
        color: var(--color-slot-booked-text);
    }

    .pill-past {
        background: #e2e8f0;
        color: var(--color-slot-past-text);
    }

    .time-range {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
        margin-bottom: 0.4rem;
    }

    .duration-tag {
        font-size: 0.8rem;
        color: var(--color-primary-medium);
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .slot-pricing-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 0.85rem;
        border-top: 1px dashed var(--color-border-light);
    }

    .slot-price-label {
        font-size: 0.85rem;
        color: var(--color-text-body);
    }

    .slot-price-value {
        font-size: 1.35rem;
        font-weight: 900;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    /* Primary CTA Button per Section 5.3 (>= 48px touch target) */
    .btn-book {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        min-height: 48px;
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        background: var(--color-primary-dark);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-btn);
        font-size: 0.95rem;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn-book:hover {
        background: var(--color-primary);
        transform: translateY(-1px);
    }

    .btn-disabled {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        min-height: 48px;
        margin-top: 1rem;
        padding: 0.75rem 1rem;
        background: #e2e8f0;
        color: var(--color-slot-past-text);
        border: none;
        border-radius: var(--radius-btn);
        font-size: 0.95rem;
        font-weight: 700;
        cursor: not-allowed;
    }

    .btn-disabled.booked-btn {
        background: #fee2e2;
        color: var(--color-slot-booked-text);
    }

    /* Empty State */
    .empty-state {
        background: var(--color-card-bg);
        border: 2px dashed var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 3.5rem 1.5rem;
        text-align: center;
        color: var(--color-text-body);
    }

    .empty-state-icon {
        margin-bottom: 1.25rem;
        color: var(--color-accent-soft);
    }

    /* ==========================================================================
       Match Ticket Style Modal (بطاقة تذكرة حجز المباراة - US-04)
       ========================================================================== */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(10, 20, 10, 0.72);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 1.25rem;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .modal-backdrop.active {
        opacity: 1;
    }

    /* Ticket Container with Authentic Stadium Perforation */
    .ticket-card {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 530px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.1);
        overflow: hidden;
        position: relative;
        transform: translateY(24px) scale(0.96);
        transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .modal-backdrop.active .ticket-card {
        transform: translateY(0) scale(1);
    }

    /* Ticket Header: Dark Stadium Olive with Pattern */
    .ticket-header {
        background: linear-gradient(135deg, #1b2a15 0%, #2f4325 50%, #3e5630 100%);
        color: #ffffff;
        padding: 1.4rem 1.6rem 1.2rem;
        position: relative;
        border-bottom: 2px dashed rgba(255, 255, 255, 0.18);
    }

    .ticket-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
    }

    .ticket-brand-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.3rem 0.75rem;
        border-radius: var(--radius-pill);
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: var(--color-surface-mint);
    }

    .ticket-close-btn {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .ticket-close-btn:hover {
        background: rgba(239, 68, 68, 0.85);
        border-color: rgba(239, 68, 68, 1);
        transform: rotate(90deg);
    }

    .ticket-pitch-title {
        font-size: 1.45rem;
        font-weight: 900;
        margin: 0 0 0.4rem;
        line-height: 1.25;
        letter-spacing: -0.3px;
        color: #ffffff;
    }

    .ticket-pitch-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.88rem;
        color: rgba(255, 255, 255, 0.85);
        flex-wrap: wrap;
    }

    .ticket-pitch-meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* Ticket Body */
    .ticket-body {
        padding: 1.4rem 1.6rem 1.2rem;
        background: #ffffff;
    }

    /* Match Info Grid */
    .ticket-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .ticket-info-chip {
        background: #f8faf6;
        border: 1.5px solid #e2e8da;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .ticket-chip-label {
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--color-primary-medium);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .ticket-chip-value {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--color-text-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    /* Ticket Perforation Notches / Stub Divider */
    .ticket-perforation-divider {
        position: relative;
        height: 24px;
        display: flex;
        align-items: center;
        margin: 0.25rem -1.6rem 1rem;
    }

    .perforation-line {
        width: 100%;
        border-top: 2px dashed #cbd5e1;
    }

    .perforation-notch-left,
    .perforation-notch-right {
        position: absolute;
        width: 24px;
        height: 24px;
        background: #111a0f;
        border-radius: 50%;
        top: 0px;
    }

    .perforation-notch-right {
        right: -12px;
    }

    .perforation-notch-left {
        left: -12px;
    }

    /* Ticket Price & Barcode Stub */
    .ticket-stub {
        background: linear-gradient(135deg, #fbfcf9 0%, #f4f7f1 100%);
        border: 1.5px solid #e1e7da;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.15rem;
    }

    .ticket-price-box {
        display: flex;
        flex-direction: column;
    }

    .ticket-price-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--color-text-body);
    }

    .ticket-price-amount {
        font-size: 1.65rem;
        font-weight: 900;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
        line-height: 1.1;
    }

    .ticket-barcode-area {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.25rem;
        opacity: 0.85;
    }

    .ticket-barcode-serial {
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #64748b;
    }

    /* Cash Payment Badge */
    .ticket-cash-policy {
        background: #fefce8;
        border: 1.5px solid #fef08a;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.15rem;
    }

    /* Form Notes */
    .ticket-notes-box {
        margin-bottom: 0.5rem;
    }

    .ticket-notes-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 0.35rem;
    }

    .ticket-notes-input {
        width: 100%;
        border: 1.5px solid var(--color-border-light);
        border-radius: 10px;
        padding: 0.6rem 0.85rem;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--color-text-dark);
        background: #ffffff;
        resize: vertical;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .ticket-notes-input:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(78, 101, 61, 0.15);
    }

    /* Ticket Footer Actions */
    .ticket-footer {
        padding: 1.1rem 1.6rem 1.4rem;
        background: #f8faf6;
        border-top: 1px solid #e8ede3;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.85rem;
    }

    .btn-ticket-cancel {
        min-height: 48px;
        padding: 0.7rem 1.25rem;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: var(--radius-btn);
        color: #475569;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-ticket-cancel:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-ticket-confirm {
        min-height: 48px;
        padding: 0.7rem 1.5rem;
        background: var(--color-primary-dark);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-btn);
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 14px rgba(53, 76, 43, 0.3);
        transition: all 0.2s ease;
    }

    .btn-ticket-confirm:hover {
        background: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(53, 76, 43, 0.4);
    }
</style>
@endpush

@section('content')
    <!-- Pitch Hero Header per Design-System Section 5.1 -->
    <div class="pitch-header">
        <div class="pitch-title-area">
            <h1>{{ $pitch->name }}</h1>
            <div class="pitch-meta">
                <span>
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $pitch->location }}
                </span>
                <span>
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    {{ $pitch->contact_phone }}
                </span>
                <span class="turf-badge">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                    </svg>
                    {{ match($pitch->turf_type) {
                        'artificial' => 'عشب صناعي درجة أولى',
                        'natural' => 'عشب طبيعي فاخر',
                        'hybrid' => 'عشب هجين معتمد',
                        default => $pitch->turf_type
                    } }}
                </span>
            </div>
            @if($pitch->description)
                <p style="margin-top: 0.75rem; color: var(--color-text-body); font-size: 0.92rem; line-height: 1.6;">
                    {{ $pitch->description }}
                </p>
            @endif
        </div>
        <div class="pitch-rate">
            <span class="rate-label">سعر الساعة الأساسي</span>
            <div class="rate-value">{{ number_format($pitch->hourly_rate, 2) }} <small style="font-size: 0.9rem;">ريال</small></div>
        </div>
    </div>

    <!-- Date Navigation Section -->
    <div class="section-title">
        <span class="section-title-label">
            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                <line x1="16" x2="16" y1="2" y2="6"/>
                <line x1="8" x2="8" y1="2" y2="6"/>
                <line x1="3" x2="21" y1="10" y2="10"/>
            </svg>
            اختر تاريخ المباراة
        </span>
        <form method="GET" action="{{ route('pitches.slots', $pitch->id) }}" id="customDateForm">
            <div class="custom-date-picker">
                <span>اختر تاريخ آخر:</span>
                <input type="date" name="date" id="customDateInput" value="{{ $selectedDate }}" min="{{ date('Y-m-d') }}">
            </div>
        </form>
    </div>

    <!-- 7-Days Quick Tabs (Mobile-First Touch Friendly) -->
    <div class="date-nav-wrapper" id="dateTabsWrapper">
        @foreach($dateTabs as $tab)
            <a href="{{ route('pitches.slots', ['pitch' => $pitch->id, 'date' => $tab['date']]) }}" 
               class="date-pill {{ $tab['is_selected'] ? 'active' : '' }}"
               data-date="{{ $tab['date'] }}"
               role="button"
               aria-pressed="{{ $tab['is_selected'] ? 'true' : 'false' }}">
                <span class="pill-day">{{ $tab['is_today'] ? 'اليوم' : $tab['day_name'] }}</span>
                <span class="pill-date">{{ $tab['formatted'] }}</span>
            </a>
        @endforeach
    </div>

    <!-- Status Counters Bar -->
    <div class="counters-bar">
        <div class="counter-tag counter-available">
            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            فترات متاحة للحجز: <strong id="availableCount">{{ $availableCount }}</strong>
        </div>
        <div class="counter-tag counter-booked">
            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" x2="9" y1="9" y2="15"/>
                <line x1="9" x2="15" y1="9" y2="15"/>
            </svg>
            فترات محجوزة: <strong id="bookedCount">{{ $bookedCount }}</strong>
        </div>
    </div>

    <!-- Time Slots Container with Dynamic AJAX Loading Support (US-03 Criteria 5) -->
    <div id="slotsContainer" style="position: relative; min-height: 200px; transition: opacity 0.2s ease;">
        @if($slots->count() > 0)
            <div class="slots-grid">
                @foreach($slots as $slot)
                    @php
                        $isAvailable = $slot->isAvailable() && !$slot->isPast();
                        $isBooked = $slot->status === 'booked';
                        $isPast = $slot->isPast();

                        // Calculate duration
                        $start = \Carbon\Carbon::parse($slot->start_time);
                        $end = \Carbon\Carbon::parse($slot->end_time);
                        $durationMinutes = $start->diffInMinutes($end);
                        $durationText = $durationMinutes == 90 ? '90 دقيقة (ساعة ونصف)' : ($durationMinutes == 60 ? '60 دقيقة (ساعة)' : $durationMinutes . ' دقيقة');
                    @endphp

                    <div class="slot-card {{ $isAvailable ? 'available' : ($isBooked ? 'booked' : 'past') }}">
                        <div class="slot-top-row">
                            <span class="duration-tag">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $durationText }}
                            </span>

                            @if($isAvailable)
                                <span class="slot-status-pill pill-available">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8"/>
                                    </svg>
                                    متاح للحجز
                                </span>
                            @elseif($isBooked)
                                <span class="slot-status-pill pill-booked">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    محجوز مسبقاً
                                </span>
                            @else
                                <span class="slot-status-pill pill-past">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    انتهى الوقت
                                </span>
                            @endif
                        </div>

                        <div class="time-range">
                            {{ date('h:i', strtotime($slot->start_time)) }} {{ date('A', strtotime($slot->start_time)) == 'AM' ? 'صباحاً' : 'مساءً' }}
                            -
                            {{ date('h:i', strtotime($slot->end_time)) }} {{ date('A', strtotime($slot->end_time)) == 'AM' ? 'صباحاً' : 'مساءً' }}
                        </div>

                        <div class="slot-pricing-row">
                            <span class="slot-price-label">المبلغ الإجمالي للفترة:</span>
                            <span class="slot-price-value">{{ number_format($slot->price, 2) }} <small style="font-size: 0.85rem;">ريال</small></span>
                        </div>

                        @if($isAvailable)
                            @guest
                                <a href="{{ route('login') }}" class="btn-book" style="text-decoration: none;" aria-label="تسجيل الدخول لحجز هذه الفترة">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/>
                                    </svg>
                                    تسجيل الدخول للحجز
                                </a>
                            @else
                                <button type="button" 
                                        class="btn-book open-booking-modal" 
                                        data-slot-id="{{ $slot->id }}"
                                        data-time-range="{{ date('h:i', strtotime($slot->start_time)) }} {{ date('A', strtotime($slot->start_time)) == 'AM' ? 'صباحاً' : 'مساءً' }} - {{ date('h:i', strtotime($slot->end_time)) }} {{ date('A', strtotime($slot->end_time)) == 'AM' ? 'صباحاً' : 'مساءً' }}"
                                        data-duration="{{ $durationText }}"
                                        data-price="{{ number_format($slot->price, 2) }}"
                                        data-date="{{ $selectedDate }}"
                                        aria-label="احجز هذه الفترة الآن">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
                                        <path d="M13 5v2"/>
                                        <path d="M13 17v2"/>
                                        <path d="M13 11v2"/>
                                    </svg>
                                    احجز هذه الفترة
                                </button>
                            @endguest
                        @elseif($isBooked)
                            <button type="button" class="btn-disabled booked-btn" disabled>
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                محجوز مسبقاً
                            </button>
                        @else
                            <button type="button" class="btn-disabled" disabled>
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/>
                                </svg>
                                انتهى الوقت
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                        <line x1="10" x2="14" y1="14" y2="18"/>
                        <line x1="14" x2="10" y1="14" y2="18"/>
                    </svg>
                </div>
                <h3>لا توجد فترات مجدولة لهذا التاريخ</h3>
                <p>لم يقم صاحب الملعب بإدراج أي فترات زمنية متاحة للحجز في تاريخ {{ $selectedDate }}.</p>
            </div>
        @endif
    </div>

    <!-- Booking Confirmation Modal: Match Ticket Style (US-04 Acceptance Criteria 2 & 3) -->
    <div id="bookingModal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="ticket-card">
            <!-- Ticket Top Header (Dark Olive Stadium Header) -->
            <div class="ticket-header">
                <div class="ticket-header-top">
                    <span class="ticket-brand-badge">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="m4.93 4.93 4.24 4.24"/>
                            <path d="m14.83 9.17 4.24-4.24"/>
                            <path d="m14.83 14.83 4.24 4.24"/>
                            <path d="m9.17 14.83-4.24 4.24"/>
                            <circle cx="12" cy="12" r="4"/>
                        </svg>
                        تذكرة حجز مباراة معتمدة • MATCH PASS
                    </span>
                    <button type="button" class="ticket-close-btn" id="closeModalBtn" aria-label="إغلاق التذكرة">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <h3 id="modalTitle" class="ticket-pitch-title">{{ $pitch->name }}</h3>
                <div class="ticket-pitch-meta">
                    <span>
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $pitch->location }}
                    </span>
                    <span>
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                        </svg>
                        {{ match($pitch->turf_type) {
                            'artificial' => 'عشب صناعي معتمد',
                            'natural' => 'عشب طبيعي فاخر',
                            'hybrid' => 'عشب هجين متطور',
                            default => $pitch->turf_type
                        } }}
                    </span>
                </div>
            </div>

            <!-- Booking Form -->
            <form method="POST" action="{{ route('bookings.store') }}" id="bookingForm" style="margin: 0;">
                @csrf
                <input type="hidden" name="time_slot_id" id="modalSlotId" value="">

                <!-- Ticket Body -->
                <div class="ticket-body">
                    <!-- Match Information Grid -->
                    <div class="ticket-info-grid">
                        <div class="ticket-info-chip">
                            <span class="ticket-chip-label">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/>
                                    <line x1="8" x2="8" y1="2" y2="6"/>
                                    <line x1="3" x2="21" y1="10" y2="10"/>
                                </svg>
                                تاريخ المباراة
                            </span>
                            <span class="ticket-chip-value" id="modalDateText">{{ $selectedDate }}</span>
                        </div>

                        <div class="ticket-info-chip">
                            <span class="ticket-chip-label">
                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                توقيت الفترة
                            </span>
                            <span class="ticket-chip-value" id="modalTimeText">--</span>
                        </div>
                    </div>

                    <!-- Perforation Line with Stub Notches -->
                    <div class="ticket-perforation-divider">
                        <div class="perforation-notch-right"></div>
                        <div class="perforation-line"></div>
                        <div class="perforation-notch-left"></div>
                    </div>

                    <!-- Ticket Price & Barcode Stub -->
                    <div class="ticket-stub">
                        <div class="ticket-price-box">
                            <span class="ticket-price-label">إجمالي المبلغ المستحق:</span>
                            <span class="ticket-price-amount" id="modalPriceText">--</span>
                        </div>
                        <div class="ticket-barcode-area">
                            <svg width="120" height="28" viewBox="0 0 120 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="2" width="3" height="24" fill="#354C2B"/>
                                <rect x="8" y="2" width="1.5" height="24" fill="#354C2B"/>
                                <rect x="12" y="2" width="4" height="24" fill="#354C2B"/>
                                <rect x="19" y="2" width="2" height="24" fill="#354C2B"/>
                                <rect x="24" y="2" width="1.5" height="24" fill="#354C2B"/>
                                <rect x="28" y="2" width="3" height="24" fill="#354C2B"/>
                                <rect x="34" y="2" width="2" height="24" fill="#354C2B"/>
                                <rect x="39" y="2" width="4" height="24" fill="#354C2B"/>
                                <rect x="46" y="2" width="1.5" height="24" fill="#354C2B"/>
                                <rect x="50" y="2" width="3" height="24" fill="#354C2B"/>
                                <rect x="56" y="2" width="2" height="24" fill="#354C2B"/>
                                <rect x="61" y="2" width="3" height="24" fill="#354C2B"/>
                                <rect x="67" y="2" width="1.5" height="24" fill="#354C2B"/>
                                <rect x="71" y="2" width="4" height="24" fill="#354C2B"/>
                                <rect x="78" y="2" width="2" height="24" fill="#354C2B"/>
                                <rect x="83" y="2" width="3" height="24" fill="#354C2B"/>
                                <rect x="89" y="2" width="1.5" height="24" fill="#354C2B"/>
                                <rect x="93" y="2" width="4" height="24" fill="#354C2B"/>
                                <rect x="100" y="2" width="2" height="24" fill="#354C2B"/>
                                <rect x="105" y="2" width="3" height="24" fill="#354C2B"/>
                                <rect x="111" y="2" width="2" height="24" fill="#354C2B"/>
                                <rect x="116" y="2" width="2" height="24" fill="#354C2B"/>
                            </svg>
                            <span class="ticket-barcode-serial">KP-MATCH-PASS-{{ date('Y') }}</span>
                        </div>
                    </div>

                    <!-- Cash Payment Policy Notice (US-04 Criteria 3) -->
                    <div class="ticket-cash-policy">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #92400e; flex-shrink: 0; margin-top: 2px;">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                        <div>
                            <strong style="display: block; color: #92400e; font-size: 0.9rem; margin-bottom: 0.2rem;">
                                طريقة الدفع المعتمدة (شرط التذكرة):
                            </strong>
                            <span style="font-size: 0.85rem; color: #78350f; line-height: 1.5; display: block;">
                                الدفع يتم نقداً كاش في مقر الملعب عند الحضور قبل انطلاق موعد المباراة.
                            </span>
                        </div>
                    </div>

                    <!-- Captain's Optional Notes -->
                    <div class="ticket-notes-box">
                        <label for="modalNotes" class="ticket-notes-label">
                            ملاحظات إضافية للكابتن (اختياري):
                        </label>
                        <textarea name="notes" id="modalNotes" rows="2" class="ticket-notes-input" placeholder="مثلاً: اسم الفريق، لون القمصان، أو طلب كرات إضافية..."></textarea>
                    </div>
                </div>

                <!-- Ticket Actions Footer -->
                <div class="ticket-footer">
                    <button type="button" class="btn-ticket-cancel" id="cancelModalBtn">
                        تراجع
                    </button>
                    <button type="submit" class="btn-ticket-confirm" id="confirmBookingBtn">
                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        تثبيت وتأكيد الحجز
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pitchId = {{ $pitch->id }};
        const isGuest = {{ auth()->guest() ? 'true' : 'false' }};
        const dateTabs = document.querySelectorAll('.date-pill');
        const customDateInput = document.getElementById('customDateInput');
        const slotsContainer = document.getElementById('slotsContainer');
        const availableCountEl = document.getElementById('availableCount');
        const bookedCountEl = document.getElementById('bookedCount');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        // Modal Elements
        const bookingModal = document.getElementById('bookingModal');
        const modalSlotId = document.getElementById('modalSlotId');
        const modalDateText = document.getElementById('modalDateText');
        const modalTimeText = document.getElementById('modalTimeText');
        const modalPriceText = document.getElementById('modalPriceText');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const bookingForm = document.getElementById('bookingForm');
        const confirmBookingBtn = document.getElementById('confirmBookingBtn');

        // Modal Open / Close Logic
        function openModal(data) {
            if (!bookingModal) return;
            if (modalSlotId) modalSlotId.value = data.slotId;
            if (modalDateText) modalDateText.textContent = data.date;
            if (modalTimeText) modalTimeText.textContent = data.timeRange;
            if (modalPriceText) modalPriceText.textContent = data.price + ' ريال';
            bookingModal.style.display = 'flex';
            requestAnimationFrame(() => {
                bookingModal.classList.add('active');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            if (!bookingModal) return;
            bookingModal.classList.remove('active');
            setTimeout(() => {
                bookingModal.style.display = 'none';
                document.body.style.overflow = '';
            }, 250);
        }

        // Global Event Delegation for Booking Modal Open (SSR + AJAX dynamic cards)
        document.addEventListener('click', function (e) {
            const bookBtn = e.target.closest('.open-booking-modal');
            if (!bookBtn) return;
            e.preventDefault();
            openModal({
                slotId: bookBtn.dataset.slotId,
                timeRange: bookBtn.dataset.timeRange,
                price: bookBtn.dataset.price,
                date: bookBtn.dataset.date || (customDateInput ? customDateInput.value : '')
            });
        });

        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

        if (bookingModal) {
            bookingModal.addEventListener('click', function (e) {
                if (e.target === bookingModal) {
                    closeModal();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && bookingModal && bookingModal.classList.contains('active')) {
                closeModal();
            }
        });

        // Prevent double submit on confirmation
        if (bookingForm && confirmBookingBtn) {
            bookingForm.addEventListener('submit', function () {
                confirmBookingBtn.disabled = true;
                confirmBookingBtn.innerHTML = `
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: spin 1s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                        <path d="M12 2a10 10 0 0 1 10 10"/>
                    </svg>
                    جاري تأكيد الحجز...
                `;
            });
        }

        // Format 24h time to 12h Arabic
        function formatArabicTime(timeStr) {
            if (!timeStr) return '';
            const parts = timeStr.split(':');
            let hours = parseInt(parts[0], 10);
            const minutes = parts[1];
            const period = hours >= 12 ? 'مساءً' : 'صباحاً';
            hours = hours % 12 || 12;
            const formattedHours = hours < 10 ? '0' + hours : hours;
            return `${formattedHours}:${minutes} ${period}`;
        }

        // Fetch slots dynamically via API/AJAX (US-03 Acceptance Criteria 5)
        async function loadSlots(targetDate) {
            slotsContainer.style.opacity = '0.5';

            try {
                const response = await fetch(`/api/pitches/${pitchId}/slots?date=${targetDate}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    alert(result.message || 'تعذر جلب فترات الساعات للتاريخ المحدد.');
                    slotsContainer.style.opacity = '1';
                    return;
                }

                const data = result.data;
                const slots = data.slots || [];

                // Update Counters
                if (availableCountEl) availableCountEl.textContent = data.available_count ?? slots.filter(s => s.is_available).length;
                if (bookedCountEl) bookedCountEl.textContent = data.booked_count ?? slots.filter(s => s.status === 'booked').length;

                // Update Date Tabs active state
                dateTabs.forEach(pill => {
                    const pillDate = pill.getAttribute('data-date');
                    const isSelected = pillDate === targetDate;
                    pill.classList.toggle('active', isSelected);
                    pill.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                });

                // Update custom date input
                if (customDateInput) {
                    customDateInput.value = targetDate;
                }

                // Render slots grid or empty state
                if (slots.length > 0) {
                    let html = '<div class="slots-grid">';
                    slots.forEach(slot => {
                        const isAvail = slot.is_available;
                        const isBooked = slot.status === 'booked';
                        const cardClass = isAvail ? 'available' : (isBooked ? 'booked' : 'past');

                        let statusBadgeHtml = '';
                        let buttonHtml = '';

                        const startFormatted = formatArabicTime(slot.start_time);
                        const endFormatted = formatArabicTime(slot.end_time);
                        const formattedPrice = Number(slot.price).toLocaleString('en-US', { minimumFractionDigits: 2 });

                        if (isAvail) {
                            statusBadgeHtml = `
                                <span class="slot-status-pill pill-available">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8"/>
                                    </svg>
                                    متاح للحجز
                                </span>`;

                            if (isGuest) {
                                buttonHtml = `
                                    <a href="{{ route('login') }}" class="btn-book" style="text-decoration: none;" aria-label="تسجيل الدخول لحجز هذه الفترة">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/>
                                        </svg>
                                        تسجيل الدخول للحجز
                                    </a>`;
                            } else {
                                buttonHtml = `
                                    <button type="button" 
                                            class="btn-book open-booking-modal" 
                                            data-slot-id="${slot.id}"
                                            data-time-range="${startFormatted} - ${endFormatted}"
                                            data-price="${formattedPrice}"
                                            data-date="${targetDate}"
                                            aria-label="احجز هذه الفترة الآن">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/>
                                            <path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/>
                                        </svg>
                                        احجز هذه الفترة
                                    </button>`;
                            }
                        } else if (isBooked) {
                            statusBadgeHtml = `
                                <span class="slot-status-pill pill-booked">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    محجوز مسبقاً
                                </span>`;
                            buttonHtml = `
                                <button type="button" class="btn-disabled booked-btn" disabled>
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    محجوز مسبقاً
                                </button>`;
                        } else {
                            statusBadgeHtml = `
                                <span class="slot-status-pill pill-past">
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    انتهى الوقت
                                </span>`;
                            buttonHtml = `
                                <button type="button" class="btn-disabled" disabled>
                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"/>
                                    </svg>
                                    انتهى الوقت
                                </button>`;
                        }

                        html += `
                            <div class="slot-card ${cardClass}">
                                <div class="slot-top-row">
                                    <span class="duration-tag">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        فترة اللقاء
                                    </span>
                                    ${statusBadgeHtml}
                                </div>
                                <div class="time-range">
                                    ${startFormatted} - ${endFormatted}
                                </div>
                                <div class="slot-pricing-row">
                                    <span class="slot-price-label">المبلغ الإجمالي للفترة:</span>
                                    <span class="slot-price-value">${formattedPrice} <small style="font-size: 0.85rem;">ريال</small></span>
                                </div>
                                ${buttonHtml}
                            </div>
                        `;
                    });
                    html += '</div>';
                    slotsContainer.innerHTML = html;
                } else {
                    slotsContainer.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>
                                    <line x1="10" x2="14" y1="14" y2="18"/><line x1="14" x2="10" y1="14" y2="18"/>
                                </svg>
                            </div>
                            <h3>لا توجد فترات مجدولة لهذا التاريخ</h3>
                            <p>لم يقم صاحب الملعب بإدراج أي فترات زمنية متاحة للحجز في تاريخ ${targetDate}.</p>
                        </div>
                    `;
                }

                // Update Browser History without full page refresh
                const newUrl = `/pitches/${pitchId}/slots?date=${targetDate}`;
                window.history.pushState({ date: targetDate }, '', newUrl);

            } catch (err) {
                console.error('Failed to load slots asynchronously:', err);
                // Fallback to standard HTTP navigation if fetch fails
                window.location.href = `/pitches/${pitchId}/slots?date=${targetDate}`;
            } finally {
                slotsContainer.style.opacity = '1';
            }
        }

        // Attach event listeners to date tabs
        dateTabs.forEach(pill => {
            pill.addEventListener('click', function (e) {
                e.preventDefault();
                const targetDate = this.getAttribute('data-date');
                if (targetDate) {
                    loadSlots(targetDate);
                }
            });
        });

        // Attach event listener to custom date input
        if (customDateInput) {
            customDateInput.addEventListener('change', function () {
                const targetDate = this.value;
                if (targetDate) {
                    loadSlots(targetDate);
                }
            });
        }

        // Support Browser Back/Forward buttons
        window.addEventListener('popstate', function (e) {
            const urlParams = new URLSearchParams(window.location.search);
            const targetDate = urlParams.get('date') || new Date().toISOString().slice(0, 10);
            loadSlots(targetDate);
        });
    });
</script>
@endpush
