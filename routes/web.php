<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — مسارات منصة كورة بلص
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية (Landing Page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// استعراض الملاعب (FR-02)
Route::get('/pitches', function () {
    return view('pitches.index');
})->name('pitches.index');

// مسارات الزوار غير المسجلين (Guest Routes)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// مسارات المستخدمين المسجلين (Authenticated Routes)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // مسارات خاصة بأصحاب الملاعب فقط (Owner-Only Protected Area)
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', function () {
            return view('owner.dashboard');
        })->name('dashboard');
    });
});
