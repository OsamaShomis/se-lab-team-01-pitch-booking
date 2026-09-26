<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pitch;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerDashboardController extends Controller
{
    /**
     * Display the pitch owner dashboard, today's schedule, and daily statistics.
     */
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        // Local development convenience: auto-login sample owner if not authenticated
        if (!$user && app()->environment('local') && !app()->runningUnitTests()) {
            $user = \App\Models\User::where('role', 'owner')->first();
            if ($user) {
                auth()->login($user);
            }
        }

        // Enforce owner authorization
        if (!$user || !$user->isOwner()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة تحكم أصحاب الملاعب.');
        }

        // Retrieve pitches owned by this user
        $pitches = Pitch::where('owner_id', $user->id)->get();

        // Determine selected pitch and date
        $selectedPitchId = $request->query('pitch_id', $pitches->first()?->id);
        $selectedDate = $request->query('date', Carbon::today()->format('Y-m-d'));

        $selectedPitch = $pitches->firstWhere('id', (int) $selectedPitchId);

        // Security check: if pitch requested does not belong to owner
        if ($selectedPitchId && !$selectedPitch) {
            abort(403, 'لا تملك صلاحية استعراض هذا الملعب.');
        }

        // Fetch time slots and associated bookings for the selected pitch & date
        $timeSlots = collect();
        $stats = [
            'total_bookings' => 0,
            'confirmed_count' => 0,
            'completed_count' => 0,
            'cancelled_count' => 0,
            'total_revenue' => 0.0,
            'occupancy_rate' => 0,
        ];

        if ($selectedPitch) {
            $timeSlots = $selectedPitch->timeSlots()
                ->whereDate('date', $selectedDate)
                ->with(['booking.user'])
                ->orderBy('start_time')
                ->get();

            $bookings = $timeSlots->pluck('booking')->filter();

            $totalSlotsCount = $timeSlots->count();
            $stats['total_bookings'] = $bookings->count();
            $stats['confirmed_count'] = $bookings->where('status', 'confirmed')->count();
            $stats['completed_count'] = $bookings->where('status', 'completed')->count();
            $stats['cancelled_count'] = $bookings->where('status', 'cancelled')->count();
            
            $stats['total_revenue'] = (float) $bookings->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_price');

            $activeBookingsCount = $stats['confirmed_count'] + $stats['completed_count'];
            $stats['occupancy_rate'] = $totalSlotsCount > 0 
                ? round(($activeBookingsCount / $totalSlotsCount) * 100) 
                : 0;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pitches' => $pitches,
                    'selected_pitch' => $selectedPitch,
                    'selected_date' => $selectedDate,
                    'stats' => $stats,
                    'time_slots' => $timeSlots,
                ],
            ]);
        }

        return view('owner.dashboard', compact('pitches', 'selectedPitch', 'selectedDate', 'stats', 'timeSlots'));
    }

    /**
     * Show schedule for a specific pitch.
     */
    public function show(Request $request, Pitch $pitch): View|JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (!$user || !$user->isOwner() || $pitch->owner_id !== $user->id) {
            abort(403, 'لا تملك صلاحية استعراض هذا الملعب.');
        }

        return redirect()->route('owner.dashboard', [
            'pitch_id' => $pitch->id,
            'date' => $request->query('date', Carbon::today()->format('Y-m-d')),
        ]);
    }

    /**
     * Update the status of a specific booking (e.g., mark completed or cancelled).
     */
    public function updateStatus(Request $request, Booking $booking): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (!$user || !$user->isOwner()) {
            abort(403, 'غير مصرح لك بتعديل حالة الحجز.');
        }

        // Verify that the booking belongs to a pitch owned by this user
        $pitch = $booking->timeSlot?->pitch;
        if (!$pitch || $pitch->owner_id !== $user->id) {
            abort(403, 'لا تملك صلاحية إدارة هذا الحجز.');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
            'notes'  => 'nullable|string|max:500',
        ]);

        $booking->status = $validated['status'];
        if (isset($validated['notes'])) {
            $booking->notes = $validated['notes'];
        }
        $booking->save();

        // Synchronize time slot availability if cancelled
        if ($booking->timeSlot) {
            if ($validated['status'] === 'cancelled') {
                $booking->timeSlot->status = 'available';
            } else {
                $booking->timeSlot->status = 'booked';
            }
            $booking->timeSlot->save();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم تحديث حالة الحجز بنجاح.',
                'data' => [
                    'booking' => $booking->fresh(['timeSlot', 'user']),
                ],
            ]);
        }

        return back()->with('success', 'تم تحديث حالة الحجز بنجاح.');
    }
}
