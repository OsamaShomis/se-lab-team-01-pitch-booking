<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'منصة كورة بلص — حجز الملاعب الرياضية')</title>

    <!-- Google Fonts: Cairo (Arabic) & Inter (Numbers) per Design-System Section 3 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================================
           KooraPlus Pitch Natural Olive Design Tokens (docs/Design-System.md)
           ========================================================================== */
        :root {
            /* Brand Palette Tokens (Section 2.A) */
            --color-primary-dark: #354C2B;   /* الأخضر الغابي الداكن */
            --color-primary: #4E653D;        /* الأخضر العشبي الأساسي */
            --color-primary-medium: #697E50; /* الزيتوني المتوسط */
            --color-accent-soft: #859864;    /* الزيتوني الناعم */
            --color-surface-mint: #A4B17B;   /* لون الميرمية */
            --color-surface-tint: #C3CA92;   /* العشبي الفاتح الباستيل */

            /* Functional States Tokens (Section 2.B) */
            --color-slot-avail-bg: #FFFFFF;
            --color-slot-avail-border: #859864;
            --color-slot-avail-text: #354C2B;

            --color-slot-booked-bg: #FEF2F2;
            --color-slot-booked-border: #FCA5A5;
            --color-slot-booked-text: #991B1B;

            --color-slot-past-bg: #F1F5F9;
            --color-slot-past-border: #E2E8F0;
            --color-slot-past-text: #94A3B8;

            /* Surfaces & Neutrals (Section 2.C) */
            --color-bg-main: #F8FAF6;        /* أوف وايت دافئ مريح للعين */
            --color-bg: #F8FAF6;
            --color-card-bg: #FFFFFF;
            --color-text-dark: #1E291C;      /* داكن عميق بلمحة زيتية */
            --color-text-main: #1E291C;
            --color-text-body: #475569;
            --color-text-muted: #64748B;
            --color-border-light: #E2E8F0;
            --color-border: #E2E8F0;

            /* Backward compatibility aliases */
            --color-secondary: #697E50;
            --color-accent: #C3CA92;
            --color-success: #15803D;
            --color-success-bg: #DCFCE7;
            --color-error: #B91C1C;
            --color-error-bg: #FEE2E2;

            /* Radii (Section 4) */
            --radius-btn: 10px;
            --radius-sm: 8px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-card: 16px;
            --radius-pill: 9999px;

            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 14px rgba(53, 76, 43, 0.08);
            --shadow-lg: 0 10px 25px rgba(53, 76, 43, 0.12);
        }

        /* Reset & Base Typography */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--color-bg-main);
            color: var(--color-text-body);
            font-family: 'Cairo', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* SVG Icon Standards (No emojis, clean vector lines) */
        .icon, .svg-icon {
            display: inline-block;
            vertical-align: middle;
            flex-shrink: 0;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ==========================================================================
           Navbar (Pitch Natural Olive Gradient)
           ========================================================================== */
        .navbar {
            background: linear-gradient(135deg, var(--color-primary-dark) 0%, #24351d 100%);
            color: #ffffff;
            padding: 0.85rem 1.5rem;
            box-shadow: 0 4px 15px rgba(53, 76, 43, 0.2);
            position: sticky;
            top: 0;
            z-index: 50;
            border-bottom: 2px solid var(--color-primary-medium);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: #ffffff;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .brand-icon-box {
            width: 36px;
            height: 36px;
            background-color: rgba(255, 255, 255, 0.12);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-surface-tint);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .brand-badge {
            background: var(--color-surface-mint);
            color: var(--color-primary-dark);
            padding: 0.2rem 0.6rem;
            border-radius: var(--radius-pill);
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            list-style: none;
        }

        .nav-link {
            color: #e2e8f0;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.45rem 0.85rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.14);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Buttons & Actions (Design-System Section 4 & 5.3) */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.55rem 1.25rem;
            min-height: 44px;
            border-radius: var(--radius-btn);
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-family: inherit;
        }

        .btn-primary {
            background-color: var(--color-primary-dark);
            color: #FFFFFF;
        }

        .btn-primary:hover {
            background-color: var(--color-primary);
            color: #FFFFFF;
        }

        .btn-secondary {
            background-color: var(--color-primary-medium);
            color: #FFFFFF;
        }

        .btn-secondary:hover {
            background-color: var(--color-primary);
        }

        .btn-accent {
            background-color: var(--color-surface-tint);
            color: var(--color-primary-dark);
        }

        .btn-accent:hover {
            background-color: var(--color-surface-mint);
        }

        .btn-outline-light {
            background-color: transparent;
            color: #FFFFFF;
            border: 1.5px solid rgba(255, 255, 255, 0.35);
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.12);
            border-color: #FFFFFF;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: rgba(255, 255, 255, 0.12);
            padding: 0.35rem 0.85rem;
            border-radius: var(--radius-pill);
            font-size: 0.88rem;
            font-weight: 600;
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .user-role-tag {
            font-size: 0.75rem;
            padding: 0.15rem 0.55rem;
            border-radius: var(--radius-pill);
            font-weight: 700;
        }

        .role-player {
            background-color: var(--color-surface-mint);
            color: var(--color-primary-dark);
        }

        .role-owner {
            background-color: #FEF3C7;
            color: #92400E;
        }

        /* Flash Alerts */
        .alerts-wrapper {
            max-width: 1200px;
            margin: 1.25rem auto 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .alert {
            padding: 0.9rem 1.25rem;
            border-radius: var(--radius-btn);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1rem;
            font-size: 0.92rem;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: var(--color-primary-dark);
            border: 1px solid var(--color-surface-mint);
        }

        .alert-error {
            background-color: var(--color-slot-booked-bg);
            color: var(--color-slot-booked-text);
            border: 1px solid var(--color-slot-booked-border);
        }

        /* Main Content Container */
        .main-content {
            flex: 1;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Footer (Pitch Natural Dark) */
        .footer {
            background: var(--color-primary-dark);
            color: #d1d5db;
            text-align: center;
            padding: 1.75rem 1.5rem;
            font-size: 0.88rem;
            margin-top: auto;
            border-top: 1px solid var(--color-primary);
        }

        .footer strong {
            color: var(--color-surface-tint);
        }

        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                align-items: stretch;
                gap: 0.85rem;
            }
            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }
            .nav-auth {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>

    @yield('styles')
    @stack('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="brand-logo">
                <span class="brand-icon-box">
                    <svg class="icon" style="width: 20px; height: 20px;" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m4.93 4.93 4.24 4.24"/>
                        <path d="m14.83 9.17 4.24-4.24"/>
                        <path d="m14.83 14.83 4.24 4.24"/>
                        <path d="m9.17 14.83-4.24 4.24"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                </span>
                <span>كورة بلص</span>
                <span class="brand-badge">KooraPlus</span>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2 2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    الرئيسية
                </a>
                <a href="{{ route('pitches.index') }}" class="nav-link {{ request()->routeIs('pitches.index') ? 'active' : '' }}">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                    استعراض الملاعب
                </a>
                <a href="{{ route('pitches.slots', 1) }}" class="nav-link {{ request()->routeIs('pitches.slots') ? 'active' : '' }}">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    جدول الساعات (FR-03)
                </a>
                @auth
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="nav-link {{ request()->routeIs('owner.*') ? 'active' : '' }}">
                            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            لوحة تحكم ملعبي
                        </a>
                    @else
                        <a href="{{ route('bookings.my') }}" class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            حجوزاتي
                        </a>
                    @endif
                @endauth
            </nav>

            <div class="nav-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-accent">
                        <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        إنشاء حساب جديد
                    </a>
                @else
                    <div class="user-pill">
                        <svg class="icon" style="width: 0.95rem; height: 0.95rem;" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>{{ auth()->user()->name }}</span>
                        <span class="user-role-tag {{ auth()->user()->isOwner() ? 'role-owner' : 'role-player' }}">
                            {{ auth()->user()->isOwner() ? 'صاحب ملعب' : 'لاعب' }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-light" style="min-height: 36px; padding: 0.35rem 0.85rem; font-size: 0.85rem;">
                            <svg class="icon" style="width: 0.9rem; height: 0.9rem;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                            خروج
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- Global Flash Messages -->
    <div class="alerts-wrapper">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <svg class="icon" style="width: 20px; height: 20px; color: var(--color-primary-dark);" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" role="alert">
                <svg class="icon" style="width: 20px; height: 20px; color: var(--color-slot-booked-text);" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>© {{ date('Y') }} <strong>منصة كورة بلص لحجز الملاعب الرياضية</strong> — فريق شيدرا (SHIDRA TEAM - Team 01)</p>
        <p style="margin-top: 0.35rem; font-size: 0.8rem; color: #9ca3af;">مشروع عملي هندسة البرمجيات — بيئة تشغيل موحدة ومعتمدة.</p>
    </footer>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
