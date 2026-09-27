<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingCancellationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\OwnerPitchController;
use App\Http\Controllers\PitchController;
use App\Http\Controllers\TimeSlotController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — مسارات منصة كورة بلص (KooraPlus)
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية (Landing Page)
Route::get('/', function () {
    $featuredPitches = \Illuminate\Support\Facades\Schema::hasTable('pitches')
        ? \App\Models\Pitch::where('is_active', true)->take(3)->get()
        : collect();
    return view('welcome', compact('featuredPitches'));
})->name('home');

// استعراض وتفاصيل الملاعب (FR-02: Pitch Catalog & Details)
Route::get('/pitches', [PitchController::class, 'index'])->name('pitches.index');
Route::get('/pitches/{pitch}', [PitchController::class, 'show'])->name('pitches.show');
Route::get('/api/pitches', [PitchController::class, 'index']);
Route::get('/api/pitches/{pitch}', [PitchController::class, 'show']);

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

    // FR-04: حجز فترة زمنية وتأكيد الحجز (Slot Reservation & Locking)
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/api/bookings', [BookingController::class, 'store']);
});

// FR-06: حجوزاتي وإلغاء الحجز (Player Bookings & Cancellation)
Route::get('/my-bookings', [BookingCancellationController::class, 'index'])->name('bookings.my');
Route::delete('/bookings/{booking}/cancel', [BookingCancellationController::class, 'cancel'])->name('bookings.cancel');
Route::delete('/api/bookings/{booking}', [BookingCancellationController::class, 'cancel']);

// FR-05 & Owner Management: لوحة تحكم صاحب الملعب وإدارة المنشأة والملاعب
Route::prefix('owner')->name('owner.')->group(function () {
    // Dashboard & Schedule Management
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/bookings/{booking}/status', [OwnerDashboardController::class, 'updateStatus'])->name('bookings.status');
    Route::post('/slots/{timeSlot}/manual-book', [OwnerDashboardController::class, 'manualBooking'])->name('slots.manual-book');


    // Pitch Management (إدارة ملاعبي)
    Route::get('/pitches', [OwnerPitchController::class, 'index'])->name('pitches.index');
    Route::get('/pitches/create', [OwnerPitchController::class, 'create'])->name('pitches.create');
    Route::post('/pitches', [OwnerPitchController::class, 'store'])->name('pitches.store');
    Route::get('/pitches/{pitch}', [OwnerPitchController::class, 'show'])->name('pitches.show');
    Route::get('/pitches/{pitch}/edit', [OwnerPitchController::class, 'edit'])->name('pitches.edit');
    Route::put('/pitches/{pitch}', [OwnerPitchController::class, 'update'])->name('pitches.update');
    Route::delete('/pitches/{pitch}', [OwnerPitchController::class, 'destroy'])->name('pitches.destroy');

    // Pitch Slots Management (إدارة الفترات والمواعيد)
    Route::post('/pitches/{pitch}/generate-slots', [OwnerPitchController::class, 'generateSlots'])->name('pitches.generate-slots');
    Route::post('/pitches/{pitch}/slots', [OwnerPitchController::class, 'storeSlot'])->name('pitches.slots.store');
    Route::delete('/pitches/{pitch}/slots/{slot}', [OwnerPitchController::class, 'deleteSlot'])->name('pitches.slots.delete');
});


