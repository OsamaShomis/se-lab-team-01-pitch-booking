<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجوزاتي — منصة كورة بلص (KooraPlus)</title>
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

        .badge-player {
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
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .header-section {
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

        .policy-card {
            background: #f1f8ed;
            border: 1px solid var(--color-surface-mint);
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .policy-icon {
            font-size: 1.5rem;
        }

        .policy-text h4 {
            color: var(--color-primary-dark);
            font-size: 0.95rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }

        .policy-text p {
            color: var(--color-primary);
            font-size: 0.85rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .alert-success {
            background: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #c8e6c9;
        }

        .alert-danger {
            background: #fee2e2;
            color: var(--color-danger);
            border: 1px solid #fecaca;
        }

        .bookings-grid {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .booking-card {
            background: var(--color-surface-white);
            border: 1px solid rgba(133, 152, 100, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .booking-card:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        }

        .booking-main {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            min-width: 250px;
        }

        .booking-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--color-primary-dark);
        }

        .booking-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.9rem;
            color: var(--color-text-muted);
        }

        .booking-meta-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .booking-reference {
            display: inline-block;
            background: #f1f5ee;
            color: var(--color-primary-dark);
            padding: 0.2rem 0.6rem;
            border-radius: 0.375rem;
            font-family: monospace;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .booking-pricing {
            text-align: left;
            min-width: 140px;
        }

        .price-label {
            font-size: 0.8rem;
            color: var(--color-text-muted);
        }

        .price-value {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--color-primary-dark);
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.825rem;
            font-weight: 700;
            text-align: center;
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

        .booking-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-end;
        }

        .btn-cancel {
            background: #fee2e2;
            color: var(--color-danger);
            border: 1px solid #fecaca;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #fca5a5;
            color: #7f1d1d;
        }

        .cancellation-note {
            font-size: 0.775rem;
            color: var(--color-text-muted);
        }

        .empty-state {
            background: var(--color-surface-white);
            border: 1px solid rgba(133, 152, 100, 0.2);
            border-radius: 1rem;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .empty-state h3 {
            color: var(--color-primary-dark);
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        .empty-state p {
            color: var(--color-text-muted);
            margin-bottom: 1.5rem;
        }

        .btn-browse {
            background: var(--color-primary-dark);
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="brand-logo">
            ⚽ كورة بلص <span class="badge-player">سجل حجوزاتي</span>
        </a>
        <div class="user-menu">
            <span>مرحباً، <strong>{{ auth()->user()->name ?? 'اللاعب' }}</strong></span>
        </div>
    </nav>

    <div class="container">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>⚠️ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Header -->
        <div class="header-section">
            <div class="page-title">
                <h1>قائمة الحجوزات والمواعيد</h1>
                <p>إدارة حجوزاتك، استعراض التفاصيل، وسياسة الإلغاء المرنة</p>
            </div>
        </div>

        <!-- Cancellation Policy Notice (BR-03) -->
        <div class="policy-card">
            <div class="policy-icon">ℹ️</div>
            <div class="policy-text">
                <h4>سياسة وقواعد الإلغاء (قاعدة العمل BR-03):</h4>
                <p>يحق لك إلغاء الحجز واسترجاع الفترة متى ما شئت، بشرط أن يتبقى <strong>ساعتان على الأقل</strong> قبل موعد بدء المباراة.</p>
            </div>
        </div>

        @if($bookings->isEmpty())
            <div class="empty-state">
                <h3>لا توجد لديك أي حجوزات سابقة أو نشطة</h3>
                <p>استعرض الملاعب المتاحة واختر الساعة المناسبة لفريقك الآن!</p>
                <a href="/" class="btn-browse">تصفح الملاعب والساعات المتاحة</a>
            </div>
        @else
            <div class="bookings-grid">
                @foreach($bookings as $booking)
                    @php
                        $slot = $booking->timeSlot;
                        $pitch = $slot?->pitch;
                        $canCancel = $booking->canBeCancelled();
                    @endphp
                    <div class="booking-card">
                        <div class="booking-main">
                            <div class="booking-title">{{ $pitch?->name ?? 'ملعب رياضي' }}</div>
                            <div class="booking-meta">
                                <div class="booking-meta-item">📍 {{ $pitch?->location ?? 'صنعاء' }}</div>
                                <div class="booking-meta-item">📅 {{ $slot?->date?->format('Y-m-d') }}</div>
                                <div class="booking-meta-item">⏰ {{ substr($slot?->start_time ?? '', 0, 5) }} — {{ substr($slot?->end_time ?? '', 0, 5) }}</div>
                            </div>
                            <div>
                                رمز الحجز: <span class="booking-reference">{{ $booking->booking_reference }}</span>
                            </div>
                        </div>

                        <div class="booking-pricing">
                            <div class="price-label">المبلغ الإجمالي</div>
                            <div class="price-value">{{ number_format($booking->total_price, 2) }} <small style="font-size: 0.8rem;">ر.ي</small></div>
                        </div>

                        <div class="booking-actions">
                            @if($booking->status === 'confirmed')
                                <span class="status-badge badge-confirmed">حجز مؤكد</span>

                                @if($canCancel)
                                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء هذا الحجز؟ سيتم إتاحة الفترة فوراً للآخرين.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-cancel">
                                            ✕ إلغاء الحجز
                                        </button>
                                    </form>
                                    <span class="cancellation-note">✓ متاح للإلغاء (يتبقى > 2 ساعة)</span>
                                @else
                                    <span class="cancellation-note" style="color: var(--color-danger); font-weight: 700;">
                                        🔒 مغلق للإلغاء (تبقى أقل من ساعتين)
                                    </span>
                                @endif

                            @elseif($booking->status === 'completed')
                                <span class="status-badge badge-completed">✓ اكتملت المباراة</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="status-badge badge-cancelled">حجز ملغي</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</body>
</html>
