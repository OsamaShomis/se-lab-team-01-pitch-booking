<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم صاحب الملعب — كورة بلص (KooraPlus)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary-dark: #354C2B;
            --color-primary: #4E653D;
            --color-primary-medium: #697E50;
            --color-accent-soft: #859864;
            --color-surface-mint: #A4B17B;
            --color-surface-tint: #C3CA92;
            --color-bg-main: #F8FAF6;
            --color-surface-white: #FFFFFF;
            --color-text-main: #1F2937;
            --color-text-muted: #6B7280;
            --color-success: #15803D;
            --color-warning: #B45309;
            --color-danger: #B91C1C;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: var(--color-bg-main);
            color: var(--color-text-main);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
            color: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(53, 76, 43, 0.15);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 900;
            color: #ffffff;
            text-decoration: none;
        }

        .badge-owner {
            background: var(--color-surface-tint);
            color: var(--color-primary-dark);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .header-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .page-title h1 {
            font-size: 1.875rem;
            color: var(--color-primary-dark);
            font-weight: 800;
        }

        .page-title p {
            color: var(--color-text-muted);
            margin-top: 0.25rem;
        }

        .filter-card {
            background: var(--color-surface-white);
            border: 1px solid rgba(133, 152, 100, 0.25);
            border-radius: 1rem;
            padding: 1.25rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--color-primary-dark);
        }

        .form-select, .form-input {
            padding: 0.6rem 1rem;
            border: 1.5px solid var(--color-surface-mint);
            border-radius: 0.5rem;
            background: #ffffff;
            font-size: 0.95rem;
            color: var(--color-text-main);
            outline: none;
            transition: all 0.2s;
        }

        .form-select:focus, .form-input:focus {
            border-color: var(--color-primary-dark);
            box-shadow: 0 0 0 3px rgba(78, 101, 61, 0.15);
        }

        .btn-filter {
            background: var(--color-primary-dark);
            color: #ffffff;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: auto;
        }

        .btn-filter:hover {
            background: var(--color-primary);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--color-surface-white);
            border-radius: 1rem;
            padding: 1.25rem;
            border: 1px solid rgba(133, 152, 100, 0.2);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--color-primary);
        }

        .stat-card.revenue::before { background: var(--color-surface-mint); }
        .stat-card.completed::before { background: var(--color-success); }
        .stat-card.cancelled::before { background: var(--color-danger); }

        .stat-title {
            font-size: 0.875rem;
            color: var(--color-text-muted);
            font-weight: 600;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-top: 0.5rem;
        }

        /* Schedule Timeline */
        .schedule-card {
            background: var(--color-surface-white);
            border-radius: 1rem;
            border: 1px solid rgba(133, 152, 100, 0.2);
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .schedule-header {
            background: #f1f5ee;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(133, 152, 100, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .schedule-header h2 {
            font-size: 1.25rem;
            color: var(--color-primary-dark);
            font-weight: 800;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        .schedule-table th {
            background: #fafbfa;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--color-primary-dark);
            border-bottom: 1px solid #e5e7eb;
        }

        .schedule-table td {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.925rem;
            vertical-align: middle;
        }

        .schedule-table tr:hover {
            background: #fafdf8;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.825rem;
            font-weight: 700;
        }

        .badge-available {
            background: #edf7ed;
            color: var(--color-success);
            border: 1px solid #c8e6c9;
        }

        .badge-confirmed {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .badge-completed {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-cancelled {
            background: #fef2f2;
            color: var(--color-danger);
            border: 1px solid #fecaca;
        }

        .action-form {
            display: inline-flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.4rem 0.85rem;
            border-radius: 0.375rem;
            font-size: 0.825rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-complete {
            background: var(--color-primary-medium);
            color: #ffffff;
        }

        .btn-complete:hover {
            background: var(--color-primary-dark);
        }

        .btn-cancel {
            background: #fee2e2;
            color: var(--color-danger);
        }

        .btn-cancel:hover {
            background: #fecaca;
        }

        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: var(--color-text-muted);
        }

        .empty-state h3 {
            color: var(--color-primary-dark);
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .alert-success {
            background: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #c8e6c9;
        }
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <nav class="navbar">
        <a href="#" class="brand-logo">
            ⚽ كورة بلص <span class="badge-owner">لوحة صاحب الملعب</span>
        </a>
        <div class="user-menu">
            <span>مرحباً، <strong>{{ auth()->user()->name ?? 'صاحب الملعب' }}</strong></span>
        </div>
    </nav>

    <div class="container">

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="header-section">
            <div class="page-title">
                <h1>لوحة إدارة وجدول الحجوزات اليومي</h1>
                <p>متابعة حجوزات الملاعب، تحديث حالات الحضور، وإدارة الإشغال اليومي</p>
            </div>
        </div>

        @if($pitches->isEmpty())
            <div class="schedule-card empty-state">
                <h3>لا توجد ملاعب مسجلة باسمك حالياً</h3>
                <p>لم يتم العثور على أي ملعب مرتبط بحسابك. يرجى إضافة ملعبك أولاً للبدء في استقبال الحجوزات.</p>
            </div>
        @else
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('owner.dashboard') }}" class="filter-card">
                <div class="form-group">
                    <label for="pitch_id" class="form-label">الملعب الرياضي:</label>
                    <select name="pitch_id" id="pitch_id" class="form-select">
                        @foreach($pitches as $pitch)
                            <option value="{{ $pitch->id }}" {{ $selectedPitch?->id === $pitch->id ? 'selected' : '' }}>
                                {{ $pitch->name }} ({{ $pitch->location }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="date" class="form-label">التاريخ:</label>
                    <input type="date" name="date" id="date" value="{{ $selectedDate }}" class="form-input">
                </div>

                <button type="submit" class="btn-filter">عرض الجدول</button>
            </form>

            <!-- Stats KPI Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">إجمالي فترات اليوم</div>
                    <div class="stat-value">{{ $timeSlots->count() }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">الحجوزات النشطة</div>
                    <div class="stat-value">{{ $stats['confirmed_count'] }}</div>
                </div>

                <div class="stat-card completed">
                    <div class="stat-title">الحجوزات المكتملة</div>
                    <div class="stat-value">{{ $stats['completed_count'] }}</div>
                </div>

                <div class="stat-card revenue">
                    <div class="stat-title">الإيراد المتوقع لليوم</div>
                    <div class="stat-value">{{ number_format($stats['total_revenue'], 2) }} <small style="font-size: 1rem;">ر.ي</small></div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">نسبة الإشغال</div>
                    <div class="stat-value">{{ $stats['occupancy_rate'] }}%</div>
                </div>
            </div>

            <!-- Daily Schedule Timeline -->
            <div class="schedule-card">
                <div class="schedule-header">
                    <h2>جدول فترات: {{ $selectedPitch?->name }} ليوم {{ $selectedDate }}</h2>
                    <span style="font-size: 0.9rem; color: var(--color-primary-medium); font-weight: 700;">
                        سعر الساعة: {{ number_format($selectedPitch?->hourly_rate ?? 0, 2) }} ر.ي
                    </span>
                </div>

                @if($timeSlots->isEmpty())
                    <div class="empty-state">
                        <h3>لا توجد فترات زمنية محددة لهذا اليوم</h3>
                        <p>لم يتم إنشاء أي فترات ساعات (Time Slots) لهذا التاريخ في النظام.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="schedule-table">
                            <thead>
                                <tr>
                                    <th>الفترة الزمنية</th>
                                    <th>حالة الفترة</th>
                                    <th>اللاعب / كابتن الفريق</th>
                                    <th>رقم الهاتف</th>
                                    <th>رمز الحجز</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timeSlots as $slot)
                                    @php
                                        $booking = $slot->booking;
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ substr($slot->start_time, 0, 5) }} — {{ substr($slot->end_time, 0, 5) }}</strong>
                                        </td>
                                        <td>
                                            @if($slot->status === 'available' || !$booking)
                                                <span class="status-badge badge-available">شاغرة ومتاحة</span>
                                            @elseif($booking->status === 'confirmed')
                                                <span class="status-badge badge-confirmed">مؤكد</span>
                                            @elseif($booking->status === 'completed')
                                                <span class="status-badge badge-completed">مكتمل</span>
                                            @elseif($booking->status === 'cancelled')
                                                <span class="status-badge badge-cancelled">ملغي</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $booking?->user?->name ?? '—' }}
                                        </td>
                                        <td>
                                            {{ $booking?->user?->phone ?? '—' }}
                                        </td>
                                        <td>
                                            @if($booking)
                                                <code>{{ $booking->booking_reference }}</code>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking && $booking->status === 'confirmed')
                                                <div class="action-form">
                                                    <form method="POST" action="{{ route('owner.bookings.status', $booking->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="btn-action btn-complete" title="تأكيد حضور اللاعب وانتهاء المباراة">
                                                            ✓ تم الحضور
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('owner.bookings.status', $booking->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء هذا الحجز؟');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="btn-action btn-cancel" title="إلغاء الحجز">
                                                            ✕ إلغاء
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($booking && $booking->status === 'completed')
                                                <span style="color: var(--color-success); font-weight: 700; font-size: 0.85rem;">✓ اكتمل</span>
                                            @elseif($booking && $booking->status === 'cancelled')
                                                <span style="color: var(--color-danger); font-weight: 600; font-size: 0.85rem;">تم الإلغاء</span>
                                            @else
                                                <span style="color: var(--color-text-muted); font-size: 0.85rem;">متاحة للحجز</span>
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

</body>
</html>
