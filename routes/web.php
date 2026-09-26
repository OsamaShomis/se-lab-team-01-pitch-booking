<?php

use App\Http\Controllers\OwnerDashboardController;
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
use App\Http\Controllers\TimeSlotController;
use Illuminate\Support\Facades\Route;

// Redirect root to Pitch 1 Slots Grid for immediate demonstration of FR-03
Route::get('/', function () {
    return redirect()->route('pitches.slots', ['pitch' => 1]);
});

// Pitch Owner Dashboard Routes (FR-05)
Route::middleware(['web'])->group(function () {
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/pitches/{pitch}', [OwnerDashboardController::class, 'show'])->name('owner.pitches.show');
    Route::patch('/owner/bookings/{booking}/status', [OwnerDashboardController::class, 'updateStatus'])->name('owner.bookings.status');
});
// FR-03: Time-Slot Availability Grid (Publicly accessible)
Route::get('/pitches/{pitch}/slots', [TimeSlotController::class, 'index'])->name('pitches.slots');

// API endpoint matching docs/API.md Endpoint 7
Route::get('/api/pitches/{pitch}/slots', [TimeSlotController::class, 'index']);

// FR-06: Reservation Cancellation & Player Bookings
Route::get('/my-bookings', [\App\Http\Controllers\BookingCancellationController::class, 'index'])->name('bookings.my');
Route::delete('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingCancellationController::class, 'cancel'])->name('bookings.cancel');
Route::delete('/api/bookings/{booking}', [\App\Http\Controllers\BookingCancellationController::class, 'cancel']);
