<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'منصة كورة بلص - حجز الملاعب الرياضية')</title>

    <!-- Google Fonts: Cairo (Arabic) & Inter (Numbers) per Design-System Section 3 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Inter:wght@500;700;900&display=swap" rel="stylesheet">

    <style>
        /* KooraPlus Pitch Natural Olive Design Tokens (docs/Design-System.md) */
        :root {
            /* Brand Palette Tokens */
            --color-primary-dark: #354C2B;   /* الأخضر الغابي الداكن */
            --color-primary: #4E653D;        /* الأخضر العشبي الأساسي */
            --color-primary-medium: #697E50; /* الزيتوني المتوسط */
            --color-accent-soft: #859864;    /* الزيتوني الناعم */
            --color-surface-mint: #A4B17B;   /* لون الميرمية */
            --color-surface-tint: #C3CA92;   /* العشبي الفاتح الباستيل */

            /* Functional States Tokens */
            --color-slot-avail-bg: #FFFFFF;
            --color-slot-avail-border: #859864;
            --color-slot-avail-text: #354C2B;

            --color-slot-booked-bg: #FEF2F2;
            --color-slot-booked-border: #FCA5A5;
            --color-slot-booked-text: #991B1B;

            --color-slot-past-bg: #F1F5F9;
            --color-slot-past-border: #E2E8F0;
            --color-slot-past-text: #94A3B8;

            /* Surfaces & Neutrals */
            --color-bg-main: #F8FAF6;        /* أوف وايت دافئ مريح للعين */
            --color-card-bg: #FFFFFF;
            --color-text-dark: #1E291C;      /* داكن عميق بلمحة زيتية */
            --color-text-body: #475569;
            --color-border-light: #E2E8F0;

            /* Radii */
            --radius-btn: 10px;
            --radius-card: 16px;
            --radius-pill: 9999px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--color-bg-main);
            color: var(--color-text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* SVG Icons Helper */
        .svg-icon {
            display: inline-block;
            vertical-align: middle;
            flex-shrink: 0;
        }

        /* Top Navigation with Forest Green Palette */
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

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            color: #ffffff;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .brand-badge {
            background: var(--color-surface-mint);
            color: var(--color-primary-dark);
            padding: 0.2rem 0.6rem;
            border-radius: var(--radius-pill);
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            list-style: none;
        }

        .nav-link {
            color: #e2e8f0;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
        }

        /* Main Content Container */
        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            flex: 1;
            width: 100%;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-btn);
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-error {
            background-color: var(--color-slot-booked-bg);
            color: var(--color-slot-booked-text);
            border: 1px solid var(--color-slot-booked-border);
        }

        .alert-success {
            background-color: #f0fdf4;
            color: var(--color-primary-dark);
            border: 1px solid var(--color-surface-mint);
        }

        /* Footer */
        .footer {
            background: var(--color-primary-dark);
            color: #d1d5db;
            text-align: center;
            padding: 1.75rem 1rem;
            font-size: 0.9rem;
            margin-top: auto;
            border-top: 1px solid var(--color-primary);
        }

        .footer strong {
            color: var(--color-surface-tint);
        }

        @media (max-width: 640px) {
            .nav-container {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="/" class="brand">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m4.93 4.93 4.24 4.24"/>
                    <path d="m14.83 9.17 4.24-4.24"/>
                    <path d="m14.83 14.83 4.24 4.24"/>
                    <path d="m9.17 14.83-4.24 4.24"/>
                    <circle cx="12" cy="12" r="4"/>
                </svg>
                <span>كورة بلص</span>
                <span class="brand-badge">KooraPlus</span>
            </a>
            <ul class="nav-links">
                <li><a href="/" class="nav-link">الرئيسية</a></li>
                <li><a href="{{ route('pitches.slots', 1) }}" class="nav-link active">جدول الساعات (FR-03)</a></li>
            </ul>
        </div>
    </header>

    <main class="main-content">
        @if (session('error'))
            <div class="alert alert-error" role="alert">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                    <line x1="12" x2="12" y1="9" y2="13"/>
                    <line x1="12" x2="12.01" y1="17" y2="17"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        منصة <strong>كورة بلص</strong> لحجز الملاعب الرياضية &copy; {{ date('Y') }} — فريق شيدرا (Team 01)
    </footer>

    @stack('scripts')
</body>
</html>
