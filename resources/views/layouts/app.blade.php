<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'كورة بلص') — منصة حجز الملاعب الرياضية</title>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #354C2B;
            --color-primary-hover: #293B21;
            --color-secondary: #4E653D;
            --color-accent: #D4AF37;
            --color-bg: #F8FAF6;
            --color-card-bg: #FFFFFF;
            --color-text-main: #1F2937;
            --color-text-muted: #6B7280;
            --color-border: #E5E7EB;
            --color-success: #15803D;
            --color-success-bg: #DCFCE7;
            --color-error: #B91C1C;
            --color-error-bg: #FEE2E2;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 14px rgba(53, 76, 43, 0.08);
            --shadow-lg: 0 10px 25px rgba(53, 76, 43, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }

        .icon {
            display: inline-block;
            vertical-align: middle;
            width: 1.25rem;
            height: 1.25rem;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Navbar */
        .navbar {
            background-color: var(--color-primary);
            color: #FFFFFF;
            padding: 0.9rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
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
            color: #FFFFFF;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .brand-icon-box {
            width: 34px;
            height: 34px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-accent);
        }

        .brand-badge {
            background-color: var(--color-accent);
            color: #1F2937;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            list-style: none;
        }

        .nav-link {
            color: #E2E8F0;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.92rem;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-link:hover {
            color: var(--color-accent);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.5rem 1.15rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: #FFFFFF;
        }

        .btn-primary:hover {
            background-color: var(--color-primary-hover);
        }

        .btn-accent {
            background-color: var(--color-accent);
            color: #1F2937;
        }

        .btn-accent:hover {
            background-color: #C5A028;
        }

        .btn-outline-light {
            background-color: transparent;
            color: #FFFFFF;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #FFFFFF;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: rgba(255, 255, 255, 0.12);
            padding: 0.35rem 0.85rem;
            border-radius: 30px;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .user-role-tag {
            font-size: 0.75rem;
            padding: 0.1rem 0.5rem;
            border-radius: 20px;
            font-weight: 700;
        }

        .role-player {
            background-color: #DCFCE7;
            color: #166534;
        }

        .role-owner {
            background-color: #FEF3C7;
            color: #92400E;
        }

        /* Alerts */
        .alerts-wrapper {
            max-width: 1200px;
            margin: 1.25rem auto 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .alert {
            padding: 0.9rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1rem;
            font-size: 0.92rem;
        }

        .alert-success {
            background-color: var(--color-success-bg);
            color: var(--color-success);
            border: 1px solid #BBF7D0;
        }

        .alert-error {
            background-color: var(--color-error-bg);
            color: var(--color-error);
            border: 1px solid #FECACA;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Footer */
        .footer {
            background-color: #1F2937;
            color: #9CA3AF;
            padding: 1.75rem 1.5rem;
            text-align: center;
            font-size: 0.88rem;
            margin-top: auto;
            border-top: 1px solid #374151;
        }

        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                align-items: stretch;
            }
            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }
            .nav-auth {
                justify-content: center;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="brand-logo">
                <span class="brand-icon-box">
                    <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                </span>
                <span>كورة بلص</span>
                <span class="brand-badge">KOORAPLUS</span>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2 2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    الرئيسية
                </a>
                <a href="{{ route('pitches.index') }}" class="nav-link">
                    <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                    استعراض الملاعب
                </a>
                @auth
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="nav-link">
                            <svg class="icon" style="width: 1rem; height: 1rem;" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            لوحة تحكم ملعبي
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
                        <button type="submit" class="btn btn-outline-light" style="padding: 0.35rem 0.75rem; font-size: 0.85rem;">
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
            <div class="alert alert-success">
                <svg class="icon" style="color: var(--color-success);" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg class="icon" style="color: var(--color-error);" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
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
        <p>© 2026 <strong>منصة كورة بلص لحجز الملاعب الرياضية</strong> — فريق شيدرا (SHIDRA TEAM - Team 01)</p>
        <p style="margin-top: 0.3rem; font-size: 0.8rem; color: #6B7280;">مشروع عملي هندسة البرمجيات — بيئة تشغيل معتمدة.</p>
    </footer>

    @yield('scripts')
</body>
</html>
