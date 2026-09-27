<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Store a newly created reservation in storage.
     * Implements FR-04 with strict concurrency locking and business rule enforcement.
     * (BR-01: No past slots, BR-02: Instant locking & booked status, NFR-04: Concurrency protection).
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        // Ensure user is authenticated
        if (! $user) {
            if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول لإتمام عملية الحجز.',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول أولاً لتأكيد الحجز.');
        }

        // Ensure user has player role
        if (! $user->isPlayer()) {
            if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'الحجز متاح للاعبين فقط. لا يمكن لصاحب الملعب الحجز كلاعب.',
                ], 403);
            }

            return back()->with('error', 'الحجز متاح لحسابات اللاعبين فقط.');
        }

        // Validate incoming request
        $validated = $request->validate([
            'time_slot_id' => ['required', 'integer', 'exists:time_slots,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $booking = DB::transaction(function () use ($validated, $user) {
                // 1. Lock the time slot row for update (prevents race conditions)
                $slot = TimeSlot::with('pitch')
                    ->where('id', $validated['time_slot_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                // 2. BR-01: Prevent booking slots in the past
                if ($slot->isPast()) {
                    throw new \DomainException('PAST_SLOT');
                }

                // 3. BR-02: Prevent booking slots that are not available
                if (! $slot->isAvailable()) {
                    throw new \DomainException('SLOT_NOT_AVAILABLE');
                }

                // 4. Double-check that no other confirmed booking exists for this slot
                $hasActiveBooking = Booking::where('time_slot_id', $slot->id)
                    ->where('status', 'confirmed')
                    ->exists();

                if ($hasActiveBooking) {
                    throw new \DomainException('SLOT_NOT_AVAILABLE');
                }

                // 5. Generate unique platform reference code (e.g., KP-2026-X781)
                $reference = $this->generateBookingReference();

                // 5. Create the booking record
                $booking = Booking::create([
                    'booking_reference' => $reference,
                    'user_id' => $user->id,
                    'time_slot_id' => $slot->id,
                    'total_price' => $slot->price,
                    'status' => 'confirmed',
                    'notes' => $validated['notes'] ?? null,
                ]);

                // 6. Update slot status to booked immediately
                $slot->update(['status' => 'booked']);

                return $booking;
            });
        } catch (\DomainException $e) {
            if ($e->getMessage() === 'PAST_SLOT') {
                if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لا يمكن حجز فترة زمنية سابقة لتاريخ ووقت اللحظة الحالية (BR-01).',
                        'errors' => null,
                    ], 400);
                }

                return back()->with('error', 'لا يمكن حجز فترة زمنية سابقة لتاريخ ووقت اللحظة الحالية (BR-01).');
            }

            if ($e->getMessage() === 'SLOT_NOT_AVAILABLE') {
                if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'عذراً، تم حجز هذه الفترة للتو من قبل مستخدم آخر (BR-02).',
                        'errors' => null,
                    ], 409);
                }

                return back()->with('error', 'عذراً، تم حجز هذه الفترة للتو من قِبل مستخدم آخر.. يُرجى اختيار فترة أخرى.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Fallback for database UNIQUE(time_slot_id) constraint violation
            if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'عذراً، تم حجز هذه الفترة للتو من قبل مستخدم آخر.',
                    'errors' => null,
                ], 409);
            }

            return back()->with('error', 'عذراً، تم حجز هذه الفترة للتو من قِبل مستخدم آخر.');
        }

        // Return API JSON response matching docs/API.md Endpoint 8
        if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
            $booking->load(['timeSlot.pitch']);
            $slot = $booking->timeSlot;

            return response()->json([
                'success' => true,
                'message' => 'تم تأكيد الحجز بنجاح',
                'data' => [
                    'id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'status' => $booking->status,
                    'total_price' => (float) $booking->total_price,
                    'notes' => $booking->notes,
                    'pitch' => [
                        'id' => $slot->pitch->id,
                        'name' => $slot->pitch->name,
                        'location' => $slot->pitch->location,
                    ],
                    'time_slot' => [
                        'id' => $slot->id,
                        'date' => $slot->date->format('Y-m-d'),
                        'start_time' => substr($slot->start_time, 0, 5),
                        'end_time' => substr($slot->end_time, 0, 5),
                    ],
                    'created_at' => $booking->created_at->toISOString(),
                ],
            ], 201);
        }

        // Web redirect to Player Bookings page
        return redirect()->route('bookings.my')->with('success', "تم تأكيد حجزك بنجاح! رقم الحجز المرجعي: {$booking->booking_reference}");
    }

    /**
     * Generate an alphanumeric platform booking reference code.
     * Pattern: KP-YYYY-XXXX (e.g. KP-2026-X781).
     */
    private function generateBookingReference(): string
    {
        $year = date('Y');

        do {
            $randomCode = strtoupper(Str::random(5));
            $reference = "KP-{$year}-{$randomCode}";
        } while (Booking::where('booking_reference', $reference)->exists());

        return $reference;
    }
}
