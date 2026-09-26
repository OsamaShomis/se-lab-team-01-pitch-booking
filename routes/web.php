<?php

use App\Http\Controllers\TimeSlotController;
use Illuminate\Support\Facades\Route;

// Redirect root to Pitch 1 Slots Grid for immediate demonstration of FR-03
Route::get('/', function () {
    return redirect()->route('pitches.slots', ['pitch' => 1]);
});

// FR-03: Time-Slot Availability Grid (Publicly accessible)
Route::get('/pitches/{pitch}/slots', [TimeSlotController::class, 'index'])->name('pitches.slots');

// API endpoint matching docs/API.md Endpoint 7
Route::get('/api/pitches/{pitch}/slots', [TimeSlotController::class, 'index']);

// FR-06: Reservation Cancellation & Player Bookings
Route::get('/my-bookings', [\App\Http\Controllers\BookingCancellationController::class, 'index'])->name('bookings.my');
Route::delete('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingCancellationController::class, 'cancel'])->name('bookings.cancel');
Route::delete('/api/bookings/{booking}', [\App\Http\Controllers\BookingCancellationController::class, 'cancel']);
