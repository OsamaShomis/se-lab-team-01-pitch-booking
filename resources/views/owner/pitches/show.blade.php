@extends('layouts.app')

@section('title', 'إدارة ' . $pitch->name . ' — منصة كورة بلص')

@push('styles')
<style>
    /* Pitch Show Control Room Styles */
    .pitch-profile-banner {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px -4px rgba(53, 76, 43, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .pitch-header-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .pitch-banner-img {
        width: 100px;
        height: 100px;
        border-radius: var(--radius-md);
        object-fit: cover;
        border: 2px solid var(--color-surface-mint);
    }

    .pitch-header-text h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .pitch-header-badges {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .badge-pill {
        padding: 0.35rem 0.85rem;
        border-radius: var(--radius-pill);
        font-size: 0.82rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .badge-turf {
        background: var(--color-surface-mint);
        color: var(--color-primary-dark);
    }

    .badge-active {
        background: var(--color-success-bg);
        color: var(--color-success);
        border: 1px solid rgba(21, 128, 61, 0.2);
    }

    .badge-inactive {
        background: var(--color-slot-past-bg);
        color: var(--color-text-muted);
    }

    .pitch-quick-specs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .spec-card {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .spec-icon {
        width: 46px;
        height: 46px;
        border-radius: var(--radius-md);
        background: rgba(53, 76, 43, 0.08);
        color: var(--color-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .spec-details .lbl {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        font-weight: 600;
    }

    .spec-details .val {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        font-family: 'Inter', 'Cairo', sans-serif;
    }

    /* Management Control Sections */
    .controls-split {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .controls-split {
            grid-template-columns: 1fr;
        }
    }

    .section-box {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border-light);
        border-radius: var(--radius-card);
        padding: 1.75rem;
        box-shadow: 0 4px 18px -4px rgba(53, 76, 43, 0.05);
        margin-bottom: 1.75rem;
    }

    .section-box-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid var(--color-border-light);
    }

    .section-box-header h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--color-primary-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Date Filter Nav */
    .date-filter-bar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .date-chip {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-btn);
        background: var(--color-bg-main);
        border: 1px solid var(--color-border-light);
        text-decoration: none;
        color: var(--color-text-body);
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .date-chip:hover {
        border-color: var(--color-primary-medium);
        background: #ffffff;
    }

    .date-chip.active {
        background: var(--color-primary-dark);
        color: #ffffff;
        border-color: var(--color-primary-dark);
    }

    /* Slots Table */
    .slots-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
    }

    .slots-table th {
        background-color: var(--color-bg-main);
        color: var(--color-text-dark);
        font-weight: 700;
        padding: 0.85rem 1rem;
        text-align: right;
        border-bottom: 2px solid var(--color-border-light);
    }

    .slots-table td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid var(--color-border-light);
        vertical-align: middle;
    }

    .slot-status-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.65rem;
        border-radius: var(--radius-pill);
        font-size: 0.78rem;
        font-weight: 700;
    }

    .status-available {
        background: var(--color-success-bg);
        color: var(--color-success);
    }

    .status-booked {
        background: var(--color-slot-booked-bg);
        color: var(--color-slot-booked-text);
    }

    .form-group {
        margin-bottom: 1.1rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--color-primary-dark);
        margin-bottom: 0.4rem;
    }

    .form-control {
        width: 100%;
        padding: 0.65rem 0.95rem;
        border: 1.5px solid var(--color-border-light);
        border-radius: var(--radius-btn);
        font-family: inherit;
        font-size: 0.92rem;
        color: var(--color-text-dark);
        background: #ffffff;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--color-primary-dark);
        box-shadow: 0 0 0 3px rgba(53, 76, 43, 0.12);
    }
</style>
@endpush

@section('content')
<div class="pitch-control-room-wrapper">

    <!-- Top Breadcrumb & Return -->
    <div style="margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between;">
        <a href="{{ route('owner.pitches.index') }}" class="btn btn-outline-light" style="color: var(--color-primary-dark); border-color: var(--color-border); font-size: 0.88rem; padding: 0.4rem 0.9rem;">
            <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            العودة لقائمة ملاعبي
        </a>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('pitches.slots', $pitch) }}" target="_blank" class="btn btn-accent" style="font-size: 0.88rem; padding: 0.45rem 1rem;">
                <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                معاينة صفحة الحجز للاعبين
            </a>
            <a href="{{ route('owner.pitches.edit', $pitch) }}" class="btn btn-secondary" style="font-size: 0.88rem; padding: 0.45rem 1rem;">
                <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                تعديل إعدادات الملعب
            </a>
        </div>
    </div>

    <!-- Pitch Profile Banner -->
    <div class="pitch-profile-banner">
        <div class="pitch-header-info">
            <img class="pitch-banner-img" src="{{ $pitch->image_url }}" alt="{{ $pitch->name }}" onerror="this.src='https://images.unsplash.com/photo-1529900240041-52c3ad58b021?auto=format&fit=crop&w=800&q=80'">
            <div class="pitch-header-text">
                <h1>{{ $pitch->name }}</h1>
                <div class="pitch-header-badges">
                    <span class="badge-pill badge-turf">
                        <svg class="svg-icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                        {{ $pitch->turf_label }}
                    </span>
                    <span class="badge-pill {{ $pitch->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $pitch->is_active ? '● متاح للحجز' : '○ مغلق مؤقتاً' }}
                    </span>
                    <span style="color: var(--color-text-muted); font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                        <svg class="svg-icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $pitch->location }}
                    </span>
                </div>
            </div>
        </div>

        <div style="text-align: left;">
            <span style="font-size: 0.8rem; color: var(--color-text-muted); display: block;">السعر الافتراضي للمباراة</span>
            <span style="font-size: 1.85rem; font-weight: 900; color: var(--color-primary-dark); font-family: 'Inter', 'Cairo', sans-serif;">{{ number_format($pitch->hourly_rate) }}</span>
            <span style="font-size: 0.85rem; color: var(--color-primary-medium);">ريال يمني</span>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="pitch-quick-specs">
        <div class="spec-card">
            <div class="spec-icon">
                <svg class="svg-icon" style="width: 22px; height: 22px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="spec-details">
                <div class="lbl">إجمالي الفترات المجهزة</div>
                <div class="val">{{ $allSlotsCount }}</div>
            </div>
        </div>

        <div class="spec-card">
            <div class="spec-icon" style="background: rgba(21, 128, 61, 0.1); color: var(--color-success);">
                <svg class="svg-icon" style="width: 22px; height: 22px;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="spec-details">
                <div class="lbl">الحجوزات المؤكدة</div>
                <div class="val">{{ $activeBookings }}</div>
            </div>
        </div>

        <div class="spec-card">
            <div class="spec-icon" style="background: rgba(164, 177, 123, 0.2); color: var(--color-primary-dark);">
                <svg class="svg-icon" style="width: 22px; height: 22px;" viewBox="0 0 24 24"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="spec-details">
                <div class="lbl">إجمالي الإيرادات المحققة</div>
                <div class="val">{{ number_format($totalRevenue) }} <span style="font-size: 0.8rem; font-weight: normal;">YER</span></div>
            </div>
        </div>

        <div class="spec-card">
            <div class="spec-icon">
                <svg class="svg-icon" style="width: 22px; height: 22px;" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <div class="spec-details">
                <div class="lbl">هاتف التواصل المباشر</div>
                <div class="val" style="font-size: 1rem;">{{ $pitch->contact_phone }}</div>
            </div>
        </div>
    </div>

    <!-- Main Schedule & Generator Split Layout -->
    <div class="controls-split">

        <!-- Left: Daily Time Slots Schedule Manager -->
        <div class="section-box">
            <div class="section-box-header">
                <h2>
                    <svg class="svg-icon" style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    جدول مواعيد وفترات الملعب
                </h2>
                <span style="font-size: 0.85rem; color: var(--color-text-muted);">
                    التاريخ المختار: <strong>{{ $selectedDate }}</strong>
                </span>
            </div>

            <!-- 7-Day Date Filter Strip -->
            <div class="date-filter-bar">
                @for($i = 0; $i < 7; $i++)
                    @php
                        $day = \Carbon\Carbon::today()->addDays($i);
                        $dStr = $day->format('Y-m-d');
                        $isActive = ($dStr === $selectedDate);
                    @endphp
                    <a href="{{ route('owner.pitches.show', ['pitch' => $pitch->id, 'date' => $dStr]) }}" class="date-chip {{ $isActive ? 'active' : '' }}">
                        <span>{{ $i === 0 ? 'اليوم' : ($i === 1 ? 'غداً' : $day->translatedFormat('l')) }}</span>
                        <small style="font-family: 'Inter', sans-serif; font-size: 0.75rem;">{{ $day->format('m/d') }}</small>
                    </a>
                @endfor
            </div>

            <!-- Slots Table -->
            @if($timeSlots->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="slots-table">
                        <thead>
                            <tr>
                                <th>الفترة والموعد</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>بيانات الحجز / الكابتن</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($timeSlots as $slot)
                                <tr>
                                    <td>
                                        <strong style="font-family: 'Inter', sans-serif; color: var(--color-primary-dark);">
                                            {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                        </strong>
                                    </td>
                                    <td>
                                        <span style="font-family: 'Inter', sans-serif; font-weight: 700;">{{ number_format($slot->price) }}</span>
                                        <small style="color: var(--color-text-muted);">ريال</small>
                                    </td>
                                    <td>
                                        @if($slot->status === 'available')
                                            <span class="slot-status-tag status-available">متاحة للحجز</span>
                                        @else
                                            <span class="slot-status-tag status-booked">محجوزة</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($slot->booking && $slot->booking->user)
                                            <div>
                                                <strong>{{ $slot->booking->user->name }}</strong>
                                                <div style="font-size: 0.8rem; color: var(--color-text-muted); font-family: 'Inter', sans-serif;">
                                                    {{ $slot->booking->user->phone ?? 'بدون هاتف' }} | كود: {{ $slot->booking->booking_reference }}
                                                </div>
                                            </div>
                                        @else
                                            <span style="color: var(--color-text-muted); font-size: 0.85rem;">— شاغرة —</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($slot->status === 'available')
                                            <form action="{{ route('owner.pitches.slots.delete', ['pitch' => $pitch->id, 'slot' => $slot->id]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفترة الشاغرة؟');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn" style="background: rgba(220, 38, 38, 0.1); color: #DC2626; padding: 0.3rem 0.6rem; font-size: 0.8rem; min-height: 32px;" title="حذف الفترة">
                                                    <svg class="svg-icon" style="width: 0.85rem; height: 0.85rem;" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    حذف
                                                </button>
                                            </form>
                                        @else
                                            <span style="font-size: 0.8rem; color: var(--color-text-muted);">مقفلة بالحجز</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 2.5rem 1rem; color: var(--color-text-muted);">
                    <svg class="svg-icon" style="width: 42px; height: 42px; margin-bottom: 0.75rem; color: var(--color-surface-mint);" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <p style="font-weight: 700; margin-bottom: 0.5rem;">لا توجد فترات مسجلة لهذا التاريخ ({{ $selectedDate }})</p>
                    <p style="font-size: 0.85rem;">يمكنك توليد فترات قياسية فوراً من النموذج الجانبي.</p>
                </div>
            @endif
        </div>

        <!-- Right Side: Bulk Slot Generator & Add Custom Slot -->
        <div>
            <!-- Bulk Generator Box -->
            <div class="section-box">
                <div class="section-box-header">
                    <h2>
                        <svg class="svg-icon" style="width: 1.15rem; height: 1.15rem;" viewBox="0 0 24 24"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                        توليد فترات تلقائية ذكية
                    </h2>
                </div>
                <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 1.25rem;">
                    توليد 5 فترات مسائية قياسية (مدة 90 دقيقة من 16:00 إلى 23:30) بنقرة واحدة لنطاق زمني محدد.
                </p>

                <form action="{{ route('owner.pitches.generate-slots', $pitch) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>من تاريخ:</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $selectedDate }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label>إلى تاريخ:</label>
                        <input type="date" name="end_date" class="form-control" value="{{ \Carbon\Carbon::parse($selectedDate)->addDays(3)->format('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label>سعر الفترة (ريال يمني):</label>
                        <input type="number" name="custom_price" class="form-control" value="{{ (int)$pitch->hourly_rate }}" step="500" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                        توليد الفترات الآن
                    </button>
                </form>
            </div>

            <!-- Single Custom Slot Box -->
            <div class="section-box">
                <div class="section-box-header">
                    <h2>
                        <svg class="svg-icon" style="width: 1.15rem; height: 1.15rem;" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                        إضافة فترة مفردة مخصصة
                    </h2>
                </div>

                <form action="{{ route('owner.pitches.slots.store', $pitch) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>التاريخ:</label>
                        <input type="date" name="date" class="form-control" value="{{ $selectedDate }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <div class="form-group">
                            <label>من الساعة:</label>
                            <input type="time" name="start_time" class="form-control" value="18:00" required>
                        </div>
                        <div class="form-group">
                            <label>إلى الساعة:</label>
                            <input type="time" name="end_time" class="form-control" value="19:30" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>السعر (ريال يمني):</label>
                        <input type="number" name="price" class="form-control" value="{{ (int)$pitch->hourly_rate }}" step="500" required>
                    </div>

                    <button type="submit" class="btn btn-secondary" style="width: 100%;">
                        <svg class="svg-icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        حفظ الفترة المخصصة
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
