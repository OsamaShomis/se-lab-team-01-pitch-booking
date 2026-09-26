<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegister(Request $request): View
    {
        $initialRole = $request->query('role', 'player');
        if (! in_array($initialRole, ['player', 'owner'])) {
            $initialRole = 'player';
        }

        return view('auth.register', compact('initialRole'));
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:player,owner'],
        ], [
            'name.required' => 'الاسم الكامل مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً لدينا.',
            'phone.required' => 'رقم الهاتف مطلوب للتواصل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'role.required' => 'يرجى تحديد نوع الحساب (لاعب أو صاحب ملعب).',
            'role.in' => 'نوع الحساب المحدد غير صالح.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'phone' => trim($validated['phone']),
            'password' => $validated['password'], // Automatically hashed via User model cast
            'role' => $validated['role'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isOwner()) {
            return redirect()->route('owner.dashboard')
                ->with('success', "أهلاً بك يا {$user->name}! تم إنشاء حسابك بنجاح كصاحب ملعب، يمكنك الآن إدارة ملاعبيك.");
        }

        return redirect()->route('pitches.index')
            ->with('success', "أهلاً بك يا {$user->name}! تم إنشاء حسابك بنجاح كلاعب، تصفح الملاعب المتاحة واحجز مباراتك الآن.");
    }

    /**
     * Show the login form.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'password.required' => 'يرجى إدخال كلمة المرور.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => strtolower(trim($credentials['email'])), 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isOwner()) {
                return redirect()->intended(route('owner.dashboard'))
                    ->with('success', "مرحباً بعودتك يا {$user->name}! أهلاً بك في لوحة إدارة الملاعب.");
            }

            return redirect()->intended(route('pitches.index'))
                ->with('success', "مرحباً بعودتك يا {$user->name}! استمتع بحجز أفضل الملاعب الرياضية.");
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'تم تسجيل الخروج بنجاح. نراك قريباً في ملاعب كورة بلص!');
    }
}
