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
