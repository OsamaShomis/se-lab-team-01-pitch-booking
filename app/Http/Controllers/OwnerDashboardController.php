<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * Create a manual walk-in reservation directly from the owner dashboard.
     * Fulfills US-05 Acceptance Criteria 3.
     */
    public function manualBooking(Request $request, TimeSlot $timeSlot): JsonResponse|RedirectResponse
    {

        $user = $request->user();

        if (!$user && app()->environment('local') && !app()->runningUnitTests()) {
            $user = \App\Models\User::where('role', 'owner')->first();
            if ($user) {
                auth()->login($user);
            }
        }

        if (!$user || !$user->isOwner()) {
            abort(403, 'غير مصرح لك بإجراء حجز يدوي.');
        }

        $pitch = $timeSlot->pitch;
        if (!$pitch || $pitch->owner_id !== $user->id) {
            abort(403, 'لا تملك صلاحية الحجز على هذا الملعب.');
        }

        if ($timeSlot->status !== 'available' || $timeSlot->booking) {
            $msg = 'عذراً، هذه الفترة محجوزة مسبقاً.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $validated = $request->validate([
            'captain_name' => 'required|string|max:100',
            'captain_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:300',
        ]);

        // Find or create walk-in user record
        $walkInUser = \App\Models\User::firstOrCreate(
            ['email' => 'walkin_' . preg_replace('/[^0-9]/', '', $validated['captain_phone'] ?? 'guest') . '_' . time() . '@kooraplus.local'],
            [
                'name' => $validated['captain_name'] . ' (حجز حضوري)',
                'phone' => $validated['captain_phone'] ?? '777000000',
                'role' => 'player',
                'password' => bcrypt('walkin_guest'),
            ]
        );

        $year = date('Y');
        $code = strtoupper(\Illuminate\Support\Str::random(5));
        $ref = "KP-{$year}-M{$code}";

        $bookingNotes = 'حجز يدوي مباشر عبر المالك';
        if (!empty($validated['notes'])) {
            $bookingNotes .= ' | ' . $validated['notes'];
        }

        $booking = DB::transaction(function () use ($timeSlot, $walkInUser, $ref, $bookingNotes) {
            $b = Booking::create([
                'booking_reference' => $ref,
                'user_id' => $walkInUser->id,
                'time_slot_id' => $timeSlot->id,
                'total_price' => $timeSlot->price,
                'status' => 'confirmed',
                'notes' => $bookingNotes,
            ]);

            $timeSlot->update(['status' => 'booked']);

            return $b;
        });

        $msg = "تم تسجيل الحجز اليدوي المباشر بنجاح! كود الحجز: {$ref}";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg, 'data' => $booking], 201);
        }

        return back()->with('success', $msg);
    }
}

