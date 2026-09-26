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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">

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
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 12px rgba(53, 76, 43, 0.08);
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

        /* Navbar */
        .navbar {
            background-color: var(--color-primary);
            color: #FFFFFF;
            padding: 1rem 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            gap: 0.75rem;
            text-decoration: none;
            color: #FFFFFF;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-badge {
            background-color: var(--color-accent);
            color: #1F2937;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            text-transform: uppercase;
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
            font-size: 0.95rem;
            transition: color 0.2s ease;
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
            gap: 0.5rem;
            padding: 0.55rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: #FFFFFF;
            box-shadow: 0 4px 10px rgba(53, 76, 43, 0.25);
        }

        .btn-primary:hover {
            background-color: var(--color-primary-hover);
            transform: translateY(-1px);
        }

        .btn-accent {
            background-color: var(--color-accent);
            color: #1F2937;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }

        .btn-accent:hover {
            background-color: #C5A028;
            transform: translateY(-1px);
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
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-role-tag {
            font-size: 0.75rem;
            padding: 0.15rem 0.5rem;
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
            margin: 1.5rem auto 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            animation: fadeIn 0.3s ease;
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
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
            padding: 2rem 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            margin-top: auto;
        }

        .footer a {
            color: #D1D5DB;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--color-accent);
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
                <span>⚽ كورة بلص</span>
                <span class="brand-badge">KooraPlus</span>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">الرئيسية</a>
                <a href="{{ route('pitches.index') }}" class="nav-link">استعراض الملاعب</a>
                @auth
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="nav-link">🏟️ لوحة تحكم ملعبي</a>
                    @endif
                @endauth
            </nav>

            <div class="nav-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="btn btn-accent">إنشاء حساب جديد</a>
                @else
                    <div class="user-pill">
                        <span>👋 {{ auth()->user()->name }}</span>
                        <span class="user-role-tag {{ auth()->user()->isOwner() ? 'role-owner' : 'role-player' }}">
                            {{ auth()->user()->isOwner() ? 'صاحب ملعب' : 'لاعب' }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-light" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">
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
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span>⚠️</span>
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
        <p style="margin-top: 0.4rem; font-size: 0.8rem;">مشروع عملي هندسة البرمجيات — جميع الحقوق محفوظة.</p>
    </footer>

    @yield('scripts')
</body>
</html>
