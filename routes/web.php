<?php

use App\Http\Controllers\OwnerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Pitch Owner Dashboard Routes (FR-05)
Route::middleware(['web'])->group(function () {
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    Route::get('/owner/pitches/{pitch}', [OwnerDashboardController::class, 'show'])->name('owner.pitches.show');
    Route::patch('/owner/bookings/{booking}/status', [OwnerDashboardController::class, 'updateStatus'])->name('owner.bookings.status');
});
