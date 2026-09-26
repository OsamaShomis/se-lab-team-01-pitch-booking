<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingCancellationController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\TimeSlotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — مسارات منصة كورة بلص (KooraPlus)
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

// FR-03: جدول الساعات المتاحة (Time-Slot Availability Grid - Publicly accessible)
Route::get('/pitches/{pitch}/slots', [TimeSlotController::class, 'index'])->name('pitches.slots');
Route::get('/api/pitches/{pitch}/slots', [TimeSlotController::class, 'index']);

// مسارات الزوار غير المسجلين (Guest Routes - FR-01)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// مسارات المستخدمين المسجلين (Authenticated Routes)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // FR-06: حجوزاتي وإلغاء الحجز (Player Bookings & Cancellation)
    Route::get('/my-bookings', [BookingCancellationController::class, 'index'])->name('bookings.my');
    Route::delete('/bookings/{booking}/cancel', [BookingCancellationController::class, 'cancel'])->name('bookings.cancel');
    Route::delete('/api/bookings/{booking}', [BookingCancellationController::class, 'cancel']);
});

// مسارات خاصة بأصحاب الملاعب فقط (Owner-Only Protected Area - FR-05)
Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pitches/{pitch}', [OwnerDashboardController::class, 'show'])->name('pitches.show');
    Route::patch('/bookings/{booking}/status', [OwnerDashboardController::class, 'updateStatus'])->name('bookings.status');
});
