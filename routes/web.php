<?php

use App\Http\Controllers\OwnerDashboardController;
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
