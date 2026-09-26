@extends('layouts.app')

@section('title', 'تسجيل الدخول — كورة بلص')

@section('styles')
<style>
    .auth-card {
        max-width: 480px;
        margin: 2.5rem auto 3.5rem auto;
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
        font-size: 1.65rem;
        font-weight: 800;
        margin-bottom: 0.4rem;
    }

    .auth-header p {
        color: #E2E8F0;
        font-size: 0.9rem;
    }

    .auth-body {
        padding: 2.25rem 2rem;
    }

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

    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
    }

    .remember-label {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        cursor: pointer;
        color: var(--color-text-main);
        font-weight: 600;
    }

    .btn-submit {
        width: 100%;
        padding: 0.85rem;
        font-size: 1.05rem;
    }

    /* Role Quick Shortcuts */
    .register-shortcuts {
        margin-top: 1.75rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--color-border);
        text-align: center;
    }

    .register-shortcuts-title {
        font-size: 0.85rem;
        color: var(--color-text-muted);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .shortcuts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .shortcut-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.55rem 0.5rem;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--color-border);
        background-color: #FAFAF9;
        color: var(--color-text-main);
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .shortcut-btn:hover {
        border-color: var(--color-primary);
        background-color: #F1F6EE;
        color: var(--color-primary);
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h1>تسجيل الدخول ⚽</h1>
        <p>مرحباً بك مجدداً في منصة كورة بلص الرياضية</p>
    </div>

    <div class="auth-body">
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" name="password" id="password" class="form-input @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Options: Remember Me -->
            <div class="form-options">
                <label class="remember-label">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <span>تذكرني على هذا الجهاز</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-submit">
                <span>دخول إلى حسابي</span>
                <span>←</span>
            </button>
        </form>

        <!-- Quick Register Shortcuts for Players & Owners -->
        <div class="register-shortcuts">
            <p class="register-shortcuts-title">ليس لديك حساب بعد في كورة بلص؟</p>
            <div class="shortcuts-grid">
                <a href="{{ route('register', ['role' => 'player']) }}" class="shortcut-btn">
                    <span>⚽</span>
                    <span>سجّل كلاعب</span>
                </a>
                <a href="{{ route('register', ['role' => 'owner']) }}" class="shortcut-btn">
                    <span>🏟️</span>
                    <span>سجّل كصاحب ملعب</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
