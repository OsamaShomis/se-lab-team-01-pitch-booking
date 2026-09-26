@extends('layouts.app')

@section('title', 'إنشاء حساب جديد — كورة بلص')

@section('styles')
<style>
    .auth-card {
        max-width: 580px;
        margin: 1.5rem auto 3rem auto;
        background-color: var(--color-card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--color-border);
        overflow: hidden;
    }

    .auth-header {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        color: #FFFFFF;
        padding: 2.25rem 2rem;
        text-align: center;
    }

    .auth-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .auth-header p {
        color: #E2E8F0;
        font-size: 0.95rem;
    }

    .auth-body {
        padding: 2.25rem 2rem;
    }

    /* Role Selector Cards */
    .role-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 0.75rem;
    }

    .role-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .role-card {
        position: relative;
        border: 2px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 1.25rem 1rem;
        cursor: pointer;
        transition: all 0.25s ease;
        text-align: center;
        background-color: #FAFAF9;
    }

    .role-card:hover {
        border-color: var(--color-secondary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .role-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .role-card.active {
        border-color: var(--color-primary);
        background-color: #F1F6EE;
        box-shadow: 0 0 0 1px var(--color-primary);
    }

    .role-card-icon {
        font-size: 2rem;
        margin-bottom: 0.4rem;
        display: block;
    }

    .role-card-title {
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--color-primary);
        margin-bottom: 0.2rem;
    }

    .role-card-desc {
        font-size: 0.8rem;
        color: var(--color-text-muted);
        line-height: 1.4;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
        color: var(--color-text-main);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--color-border);
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        background-color: #FFFFFF;
    }

    .form-input:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(53, 76, 43, 0.15);
    }

    .form-input.is-invalid {
        border-color: var(--color-error);
        background-color: #FFFDFD;
    }

    .field-error {
        color: var(--color-error);
        font-size: 0.82rem;
        font-weight: 600;
        margin-top: 0.35rem;
        display: block;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .btn-submit {
        width: 100%;
        padding: 0.9rem;
        font-size: 1.05rem;
        margin-top: 1rem;
    }

    .auth-footer-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--color-border);
        font-size: 0.9rem;
        color: var(--color-text-muted);
    }

    .auth-footer-link a {
        color: var(--color-primary);
        font-weight: 700;
        text-decoration: none;
    }

    .auth-footer-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .form-grid-2, .role-grid {
            grid-template-columns: 1fr;
        }
        .auth-card {
            margin: 0.5rem auto 2rem auto;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1>إنشاء حساب في كورة بلص ⚽</h1>
        <p>انضم الآن لأكبر مجتمع رياضي لحجز وإدارة ملاعب كرة القدم</p>
    </div>

    <div class="auth-body">
        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf

            <!-- Role Selector -->
            <label class="role-section-title">اختر نوع حسابك في المنصة:</label>
            <div class="role-grid">
                <!-- Player Option -->
                <label class="role-card {{ old('role', $initialRole) === 'player' ? 'active' : '' }}" id="card-player">
                    <input type="radio" name="role" value="player" {{ old('role', $initialRole) === 'player' ? 'checked' : '' }} onchange="selectRole('player')">
                    <span class="role-card-icon">⚽</span>
                    <span class="role-card-title">حساب لاعب</span>
                    <span class="role-card-desc">استكشف الملاعب، قارن الأسعار، واحجز حصتك الكروية فوراً.</span>
                </label>

                <!-- Pitch Owner Option -->
                <label class="role-card {{ old('role', $initialRole) === 'owner' ? 'active' : '' }}" id="card-owner">
                    <input type="radio" name="role" value="owner" {{ old('role', $initialRole) === 'owner' ? 'checked' : '' }} onchange="selectRole('owner')">
                    <span class="role-card-icon">🏟️</span>
                    <span class="role-card-title">صاحب ملعب</span>
                    <span class="role-card-desc">أضف ملاعبك، نظّم الساعات الشاغرة، واستقبل الحجوزات بكل سهولة.</span>
                </label>
            </div>
            @error('role')
                <span class="field-error" style="margin-top: -1rem; margin-bottom: 1rem;">{{ $message }}</span>
            @enderror

            <!-- Name Field -->
            <div class="form-group">
                <label for="name" class="form-label">الاسم الكامل</label>
                <input type="text" name="name" id="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="مثال: أسامة الشميس" required autofocus>
                @error('name')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email & Phone (Grid) -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@example.com" required>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="05XXXXXXXX" required>
                    @error('phone')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Password & Confirmation (Grid) -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" name="password" id="password" class="form-input @error('password') is-invalid @enderror" placeholder="8 أحرف كحد أدنى" required>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="أعد كتابة كلمة المرور" required>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-submit">
                <span>إنشاء الحساب وبدء التجربة</span>
                <span>🚀</span>
            </button>
        </form>

        <div class="auth-footer-link">
            <span>لديك حساب بالفعل في كورة بلص؟</span>
            <a href="{{ route('login') }}">تسجيل الدخول هنا</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectRole(role) {
        document.getElementById('card-player').classList.remove('active');
        document.getElementById('card-owner').classList.remove('active');

        if (role === 'player') {
            document.getElementById('card-player').classList.add('active');
        } else if (role === 'owner') {
            document.getElementById('card-owner').classList.add('active');
        }
    }
</script>
@endsection
