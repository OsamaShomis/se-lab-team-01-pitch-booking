@extends('layouts.app')

@section('title', 'لوحة تحكم صاحب الملعب — كورة بلص')

@push('styles')
<style>
    /* ==========================================================================
       Owner Dashboard Premium Styling (Pitch Natural Olive Theme)
       ========================================================================== */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    /* Dashboard Header */
    .dash-header {
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

    .dash-title-group h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .dash-title-group p {
        color: var(--color-text-body);
        font-size: 0.95rem;
    }

    .pitch-badge-info {
        background-color: #F1F6EE;
        border: 1px solid var(--color-surface-mint);
        color: var(--color-primary-dark);
        padding: 0.5rem 1rem;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Filter Toolbar Card */
    .filter-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.25rem 1.75rem;
        box-shadow: 0 2px 12px rgba(53, 76, 43, 0.04);
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.25rem;
    }

    .filter-inputs {
        display: flex;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        flex: 1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        min-width: 220px;
        flex: 1;
    }

    .form-label {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--color-primary-dark);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-select, .form-input {
        width: 100%;
        padding: 0.65rem 1rem;
        border: 1.5px solid var(--color-border-light);
        border-radius: var(--radius-btn);
        background-color: #FFFFFF;
        color: var(--color-text-dark);
        font-size: 0.95rem;
        font-family: inherit;
        font-weight: 600;
        transition: all 0.2s ease;
        outline: none;
    }

    .form-select:focus, .form-input:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(78, 101, 61, 0.15);
    }

    .btn-filter-submit {
        background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
        color: #FFFFFF;
        border: none;
        padding: 0.7rem 1.75rem;
        border-radius: var(--radius-btn);
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-height: 44px;
        box-shadow: 0 4px 12px rgba(53, 76, 43, 0.15);
    }

    .btn-filter-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(53, 76, 43, 0.25);
    }

    /* KPI Metrics Grid (5 Balanced Cards) */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1.25rem;
    }

    .kpi-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(53, 76, 43, 0.08);
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 5px;
        height: 100%;
        background-color: var(--color-primary-medium);
    }

    .kpi-card.kpi-active::before { background-color: #2563EB; }
    .kpi-card.kpi-completed::before { background-color: var(--color-success); }
    .kpi-card.kpi-revenue::before { background-color: #D97706; }
    .kpi-card.kpi-occupancy::before { background-color: var(--color-primary-dark); }

    .kpi-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .kpi-label {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--color-text-body);
    }

    .kpi-icon-box {
        width: 38px;
        height: 38px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #F1F6EE;
        color: var(--color-primary-dark);
    }

    .kpi-value {
        font-size: 1.85rem;
        font-weight: 900;
        color: var(--color-text-dark);
        line-height: 1.1;
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    .kpi-revenue .kpi-value {
        color: #92400E;
    }

    .kpi-currency {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--color-text-body);
        margin-right: 0.25rem;
    }

    /* Occupancy Progress Bar */
    .occupancy-bar-wrapper {
        margin-top: 0.65rem;
        width: 100%;
        height: 6px;
        background-color: #E2E8F0;
        border-radius: 9999px;
        overflow: hidden;
    }

    .occupancy-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--color-primary-medium), var(--color-primary-dark));
        border-radius: 9999px;
        transition: width 0.5s ease-in-out;
    }

    /* Schedule Table Container Card */
    .schedule-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        box-shadow: 0 4px 20px -4px rgba(53, 76, 43, 0.06);
        overflow: hidden;
    }

    .schedule-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--color-border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        background-color: #FAFBF9;
    }

    .schedule-header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .schedule-header-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-primary-dark);
    }

    .schedule-rate-badge {
        background-color: #FFFFFF;
        border: 1px solid var(--color-border-light);
        padding: 0.35rem 0.85rem;
        border-radius: var(--radius-pill);
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-primary);
    }

    /* Table Styling */
    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        text-align: right;
    }

    .schedule-table th {
        background-color: #F8FAF6;
        color: var(--color-text-body);
        font-weight: 700;
        font-size: 0.85rem;
        padding: 1rem 1.5rem;
        border-bottom: 1.5px solid var(--color-border-light);
        white-space: nowrap;
    }

    .schedule-table td {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #EDF2EB;
        font-size: 0.92rem;
        vertical-align: middle;
    }

    .schedule-table tr:hover td {
        background-color: #FBFDFB;
    }

    .slot-time-text {
        font-weight: 800;
        color: var(--color-text-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
        font-size: 1rem;
        direction: ltr;
        display: inline-block;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.8rem;
        border-radius: var(--radius-pill);
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-available {
        background-color: #F1F8EE;
        color: var(--color-primary-dark);
        border: 1px solid var(--color-surface-mint);
    }

    .badge-confirmed {
        background-color: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
    }

    .badge-completed {
        background-color: #F0FDF4;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }

    .badge-cancelled {
        background-color: #FEF2F2;
        color: #B91C1C;
        border: 1px solid #FECACA;
    }

    .ref-code {
        background-color: #F1F5F9;
        border: 1px solid #CBD5E1;
        color: #334155;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        font-family: monospace;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Action Buttons in Table */
    .table-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .btn-attend {
        background-color: #15803D;
        color: #FFFFFF;
    }

    .btn-attend:hover {
        background-color: #166534;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(21, 128, 61, 0.25);
    }

    .btn-cancel-slot {
        background-color: #FEE2E2;
        color: #B91C1C;
        border: 1px solid #FCA5A5;
    }

    .btn-cancel-slot:hover {
        background-color: #FCA5A5;
        color: #7F1D1D;
    }

    /* Empty State */
    .empty-state-box {
        text-align: center;
        padding: 3.5rem 1.5rem;
        color: var(--color-text-muted);
    }

    .empty-state-box svg {
        width: 54px;
        height: 54px;
        color: var(--color-surface-mint);
        margin-bottom: 1rem;
    }

    .empty-state-box h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.4rem;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">

    <!-- Dashboard Header -->
    <div class="dash-header">
        <div class="dash-title-group">
            <h1>
                <svg class="icon" style="width: 1.75rem; height: 1.75rem; color: var(--color-primary);" viewBox="0 0 24 24">
                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                    <circle cx="12" cy="12" r="3"/>
                    <line x1="3" x2="21" y1="12" y2="12"/>
                </svg>
                <span>لوحة إدارة وجدول الحجوزات اليومي</span>
            </h1>
            <p>متابعة وتحديث فترات الملاعب، تسجيل حضور اللاعبين، والتحكم في إشغال المنشأة الرياضية.</p>
        </div>

        @if($selectedPitch)
            <div class="pitch-badge-info">
                <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>{{ $selectedPitch->name }} — {{ $selectedPitch->location }}</span>
            </div>
        @endif
    </div>

    @if($pitches->isEmpty())
        <div class="schedule-card">
            <div class="empty-state-box">
                <svg class="icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                <h3>لا توجد ملاعب مسجلة باسمك حالياً</h3>
                <p>لم يتم العثور على أي ملعب مرتبط بحسابك. تواصل مع الدعم الفني لإضافة ملعبك إلى المنصة.</p>
            </div>
        </div>
    @else
        <!-- Filter Toolbar -->
        <form method="GET" action="{{ route('owner.dashboard') }}" class="filter-card">
            <div class="filter-inputs">
                <div class="form-group">
                    <label for="pitch_id" class="form-label">
                        <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                        <span>الملعب الرياضي:</span>
                    </label>
                    <select name="pitch_id" id="pitch_id" class="form-select">
                        @foreach($pitches as $pitch)
                            <option value="{{ $pitch->id }}" {{ $selectedPitch?->id === $pitch->id ? 'selected' : '' }}>
                                {{ $pitch->name }} ({{ $pitch->location }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="date" class="form-label">
                        <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        <span>تاريخ الحجوزات:</span>
                    </label>
                    <input type="date" name="date" id="date" value="{{ $selectedDate }}" class="form-input">
                </div>
            </div>

            <button type="submit" class="btn-filter-submit">
                <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" y2="16.65"/></svg>
                <span>عرض الجدول</span>
            </button>
        </form>

        <!-- KPI Metrics Grid (5 Balanced Cards) -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-top">
                    <span class="kpi-label">إجمالي فترات اليوم</span>
                    <div class="kpi-icon-box">
                        <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <div class="kpi-value">{{ $timeSlots->count() }}</div>
            </div>

            <div class="kpi-card kpi-active">
                <div class="kpi-top">
                    <span class="kpi-label">الحجوزات النشطة</span>
                    <div class="kpi-icon-box" style="background-color: #EFF6FF; color: #1D4ED8;">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                    </div>
                </div>
                <div class="kpi-value" style="color: #1D4ED8;">{{ $stats['confirmed_count'] }}</div>
            </div>

            <div class="kpi-card kpi-completed">
                <div class="kpi-top">
                    <span class="kpi-label">الحجوزات المكتملة</span>
                    <div class="kpi-icon-box" style="background-color: #F0FDF4; color: #15803D;">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
                <div class="kpi-value" style="color: #15803D;">{{ $stats['completed_count'] }}</div>
            </div>

            <div class="kpi-card kpi-revenue">
                <div class="kpi-top">
                    <span class="kpi-label">الإيراد المتوقع لليوم</span>
                    <div class="kpi-icon-box" style="background-color: #FEF3C7; color: #92400E;">
                        <svg class="icon" viewBox="0 0 24 24"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                </div>
                <div class="kpi-value">
                    {{ number_format($stats['total_revenue'], 2) }}
                    <span class="kpi-currency">ر.ي</span>
                </div>
            </div>

            <div class="kpi-card kpi-occupancy">
                <div class="kpi-top">
                    <span class="kpi-label">نسبة الإشغال</span>
                    <div class="kpi-icon-box" style="background-color: #F1F6EE; color: var(--color-primary-dark);">
                        <svg class="icon" viewBox="0 0 24 24"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                    </div>
                </div>
                <div class="kpi-value">{{ $stats['occupancy_rate'] }}%</div>
                <div class="occupancy-bar-wrapper">
                    <div class="occupancy-bar-fill" style="width: {{ min(100, $stats['occupancy_rate']) }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Daily Schedule Table Card -->
        <div class="schedule-card">
            <div class="schedule-header">
                <div class="schedule-header-left">
                    <span class="schedule-header-title">
                        جدول فترات: <strong>{{ $selectedPitch?->name }}</strong> ليوم {{ $selectedDate }}
                    </span>
                </div>
                <div class="schedule-rate-badge">
                    سعر الساعة الأساسي: <strong>{{ number_format($selectedPitch?->hourly_rate ?? 0, 2) }} ر.ي</strong>
                </div>
            </div>

            @if($timeSlots->isEmpty())
                <div class="empty-state-box">
                    <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <h3>لا توجد فترات زمنية مجدولة لهذا اليوم</h3>
                    <p>يرجى اختيار تاريخ آخر أو تهيئة الفترات الزمنية للملعب عبر لوحة الإدارة.</p>
                </div>
            @else
                <div class="table-container">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>الفترة الزمنية</th>
                                <th>حالة الفترة</th>
                                <th>اللاعب / كابتن الفريق</th>
                                <th>رقم الهاتف للتواصل</th>
                                <th>رمز الحجز المرجعي</th>
                                <th style="text-align: center;">إجراءات المنشأة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timeSlots as $slot)
                                @php
                                    $booking = $slot->booking;
                                @endphp
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.45rem;">
                                            <svg class="icon" style="width: 1rem; height: 1rem; color: var(--color-primary-medium);" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <span class="slot-time-text">{{ substr($slot->start_time, 0, 5) }} — {{ substr($slot->end_time, 0, 5) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($slot->status === 'available' || !$booking)
                                            <span class="status-badge badge-available">
                                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                شاغرة ومتاحة
                                            </span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="status-badge badge-confirmed">
                                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                                حجز مؤكد
                                            </span>
                                        @elseif($booking->status === 'completed')
                                            <span class="status-badge badge-completed">
                                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                                مكتمل
                                            </span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="status-badge badge-cancelled">
                                                <svg class="icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                                                حجز ملغي
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking && $booking->user)
                                            <div style="display: flex; align-items: center; gap: 0.4rem; font-weight: 700; color: var(--color-primary-dark);">
                                                <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                <span>{{ $booking->user->name }}</span>
                                            </div>
                                        @else
                                            <span style="color: var(--color-text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking && $booking->user && $booking->user->phone)
                                            <a href="tel:{{ $booking->user->phone }}" style="color: var(--color-primary); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
                                                <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                                <span>{{ $booking->user->phone }}</span>
                                            </a>
                                        @else
                                            <span style="color: var(--color-text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking)
                                            <span class="ref-code">{{ $booking->booking_reference }}</span>
                                        @else
                                            <span style="color: var(--color-text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if($booking && $booking->status === 'confirmed')
                                            <div class="table-actions" style="justify-content: center;">
                                                <form method="POST" action="{{ route('owner.bookings.status', $booking->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn-action btn-attend" title="تسجيل حضور الفريق وانتهاء الفترة">
                                                        <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                                        <span>تم الحضور</span>
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('owner.bookings.status', $booking->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء هذا الحجز؟ سيتم إتاحة الفترة فوراً.');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn-action btn-cancel-slot" title="إلغاء الحجز وإتاحة الساعة">
                                                        <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                                                        <span>إلغاء</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($booking && $booking->status === 'completed')
                                            <span style="color: var(--color-success); font-weight: 700; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                                                <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                                <span>اكتملت المباراة</span>
                                            </span>
                                        @elseif($booking && $booking->status === 'cancelled')
                                            <span style="color: var(--color-danger); font-weight: 600; font-size: 0.85rem;">
                                                تم الإلغاء
                                            </span>
                                        @else
                                            <span style="color: var(--color-text-muted); font-size: 0.85rem; font-weight: 600;">
                                                جاهزة للحجز
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
