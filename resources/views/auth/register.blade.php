@extends('layouts.app')

@section('title', 'إنشاء حساب جديد — كورة بلص')

@section('styles')
<style>
    .auth-card {
        max-width: 520px;
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
        padding: 1.75rem 2rem;
        text-align: center;
    }

    .auth-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
    }

    .auth-header p {
        color: #E2E8F0;
        font-size: 0.88rem;
    }

    .auth-body {
        padding: 1.75rem 2rem 2.25rem 2rem;
    }

    /* Compact Sleek Role Selector */
    .role-section-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--color-text-main);
        margin-bottom: 0.6rem;
        display: block;
    }

    .role-selector-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .role-option {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.9rem;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        background-color: #FAFAF9;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .role-option:hover {
        border-color: var(--color-secondary);
        background-color: #FFFFFF;
        box-shadow: var(--shadow-sm);
    }

    .role-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .role-option.active {
        border-color: var(--color-primary);
        background-color: #F1F6EE;
        box-shadow: 0 0 0 1px var(--color-primary);
    }

    .role-radio-circle {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .role-option.active .role-radio-circle {
        border-color: var(--color-primary);
    }

    .role-radio-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--color-primary);
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.2s ease;
    }

    .role-option.active .role-radio-dot {
        opacity: 1;
        transform: scale(1);
    }

    .role-icon-box {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background-color: #FFFFFF;
        border: 1px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary);
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .role-option.active .role-icon-box {
        background-color: var(--color-primary);
        color: #FFFFFF;
        border-color: var(--color-primary);
    }

    .role-text-content {
        display: flex;
        flex-direction: column;
        text-align: right;
    }

    .role-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--color-text-main);
        line-height: 1.3;
    }

    .role-option.active .role-title {
        color: var(--color-primary);
    }

    .role-desc {
        font-size: 0.72rem;
        color: var(--color-text-muted);
        line-height: 1.2;
        margin-top: 2px;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 1.15rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 0.35rem;
        color: var(--color-text-main);
    }

    .form-input {
        width: 100%;
        padding: 0.7rem 0.9rem;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--color-border);
        font-size: 0.92rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        background-color: #FFFFFF;
    }

    .form-input:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(53, 76, 43, 0.12);
    }

    .form-input.is-invalid {
        border-color: var(--color-error);
        background-color: #FFFDFD;
    }

    .field-error {
        color: var(--color-error);
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.3rem;
        display: block;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
    }

    .btn-submit {
        width: 100%;
        padding: 0.8rem;
        font-size: 1rem;
        margin-top: 0.75rem;
    }

    .auth-footer-link {
        text-align: center;
        margin-top: 1.25rem;
        padding-top: 1.15rem;
        border-top: 1px solid var(--color-border);
        font-size: 0.88rem;
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

    @media (max-width: 540px) {
        .form-grid-2, .role-selector-container {
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
        <h1>إنشاء حساب جديد</h1>
        <p>انضم لمنصة كورة بلص لحجز وإدارة الملاعب الرياضية</p>
    </div>

    <div class="auth-body">
        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf

            <!-- Sleek Role Selector -->
            <label class="role-section-title">نوع الحساب:</label>
            <div class="role-selector-container">
                <!-- Player Option -->
                <label class="role-option {{ old('role', $initialRole) === 'player' ? 'active' : '' }}" id="role-opt-player">
                    <input type="radio" name="role" value="player" {{ old('role', $initialRole) === 'player' ? 'checked' : '' }} onchange="setRole('player')">
                    <div class="role-radio-circle">
                        <div class="role-radio-dot"></div>
                    </div>
                    <div class="role-icon-box">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="role-text-content">
                        <span class="role-title">حساب لاعب</span>
                        <span class="role-desc">حجز الملاعب والمباريات</span>
                    </div>
                </label>

                <!-- Pitch Owner Option -->
                <label class="role-option {{ old('role', $initialRole) === 'owner' ? 'active' : '' }}" id="role-opt-owner">
                    <input type="radio" name="role" value="owner" {{ old('role', $initialRole) === 'owner' ? 'checked' : '' }} onchange="setRole('owner')">
                    <div class="role-radio-circle">
                        <div class="role-radio-dot"></div>
                    </div>
                    <div class="role-icon-box">
                        <svg class="icon" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="12" cy="12" r="3"/><line x1="3" x2="21" y1="12" y2="12"/></svg>
                    </div>
                    <div class="role-text-content">
                        <span class="role-title">صاحب منشأة</span>
                        <span class="role-desc">إدارة الملاعب والحجوزات</span>
                    </div>
                </label>
            </div>
            @error('role')
                <span class="field-error" style="margin-top: -0.75rem; margin-bottom: 0.75rem;">{{ $message }}</span>
            @enderror

            <!-- Name Field -->
            <div class="form-group">
                <label for="name" class="form-label">الاسم الكامل</label>
                <input type="text" name="name" id="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="الاسم ثلاثي أو اسم المنشأة" required autofocus>
                @error('name')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email & Phone (Grid) -->
            <div class="form-grid-2">
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="example@mail.com" required>
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
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="إعادة كتابة كلمة المرور" required>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-submit">
                <svg class="icon" style="width: 1.05rem; height: 1.05rem;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>إنشاء الحساب</span>
            </button>
        </form>

        <div class="auth-footer-link">
            <span>لديك حساب مسبق؟</span>
            <a href="{{ route('login') }}">تسجيل الدخول</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function setRole(role) {
        document.getElementById('role-opt-player').classList.remove('active');
        document.getElementById('role-opt-owner').classList.remove('active');

        if (role === 'player') {
            document.getElementById('role-opt-player').classList.add('active');
        } else if (role === 'owner') {
            document.getElementById('role-opt-owner').classList.add('active');
        }
    }
</script>
@endsection
