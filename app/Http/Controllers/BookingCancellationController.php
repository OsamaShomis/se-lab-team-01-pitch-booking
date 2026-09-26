<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingCancellationController extends Controller
{
    /**
     * Display a list of player's bookings with cancellation status & policy indicators.
     */
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        // Local development convenience: auto-login sample player if not authenticated
        if (!$user && app()->environment('local') && !app()->runningUnitTests()) {
            $user = User::where('role', 'player')->first();
            if ($user) {
                auth()->login($user);
            }
        }

        if (!$user) {
            abort(401, 'يجب تسجيل الدخول لاستعراض حجوزاتك.');
        }

        // Fetch bookings for the authenticated player with time slot and pitch relations
        $bookings = Booking::where('user_id', $user->id)
            ->with(['timeSlot.pitch'])
            ->latest()
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'bookings' => $bookings->map(function ($booking) {
                        return [
                            'id' => $booking->id,
                            'reference' => $booking->booking_reference,
                            'status' => $booking->status,
                            'pitch_name' => $booking->timeSlot?->pitch?->name,
                            'pitch_location' => $booking->timeSlot?->pitch?->location,
                            'date' => $booking->timeSlot?->date?->format('Y-m-d'),
                            'start_time' => $booking->timeSlot?->start_time,
                            'end_time' => $booking->timeSlot?->end_time,
                            'total_price' => $booking->total_price,
                            'can_be_cancelled' => $booking->canBeCancelled(),
                        ];
                    }),
                ],
            ]);
        }

        return view('bookings.index', compact('bookings', 'user'));
    }

    /**
     * Cancel an existing booking subject to BR-03 (at least 2 hours before slot start).
     */
    public function cancel(Request $request, Booking $booking): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        // Local development convenience: auto-login sample player if not authenticated
        if (!$user && app()->environment('local') && !app()->runningUnitTests()) {
            $user = User::find($booking->user_id) ?? User::where('role', 'player')->first();
            if ($user) {
                auth()->login($user);
            }
        }

        if (!$user) {
            abort(401, 'يجب تسجيل الدخول لإلغاء الحجز.');
        }

        // Authorization check: User must own the booking, or be the pitch owner
        $isPlayerOwner = $booking->user_id === $user->id;
        $isPitchOwner = $booking->timeSlot?->pitch?->owner_id === $user->id;

        if (!$isPlayerOwner && !$isPitchOwner) {
            abort(403, 'غير مصرح لك بإلغاء هذا الحجز.');
        }

        // Check if already cancelled
        if ($booking->status === 'cancelled') {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'هذا الحجز ملغي بالفعل.',
                ], 422);
            }
            return back()->with('error', 'هذا الحجز ملغي بالفعل.');
        }

        // Check if already completed
        if ($booking->status === 'completed') {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'لا يمكن إلغاء حجز مكتمل أو منتهي.',
                ], 422);
            }
            return back()->with('error', 'لا يمكن إلغاء حجز مكتمل أو منتهي.');
        }

        // Enforce Business Rule BR-03: Cancellation must be at least 2 hours prior to slot start
        if (!$booking->canBeCancelled()) {
            $errorMessage = 'عذراً، لا يمكن إلغاء الحجز إذا تبقى أقل من ساعتين على موعد بداية المباراة (قاعدة العمل BR-03).';

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'code' => 'BR_03_CANCELLATION_DEADLINE_PASSED',
                    'message' => $errorMessage,
                ], 422);
            }

            return back()->with('error', $errorMessage);
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:300',
        ]);

        // Process cancellation inside database transaction
        DB::transaction(function () use ($booking, $validated) {
            $booking->status = 'cancelled';
            if (!empty($validated['reason'])) {
                $existingNotes = $booking->notes ? $booking->notes . ' | ' : '';
                $booking->notes = $existingNotes . 'سبب الإلغاء: ' . $validated['reason'];
            }
            $booking->save();

            // Free the associated time slot immediately (BR-02)
            if ($booking->timeSlot) {
                $booking->timeSlot->status = 'available';
                $booking->timeSlot->save();
            }
        });

        $successMessage = 'تم إلغاء الحجز بنجاح وإعادة إتاحة الفترة الزمنية للجميع.';

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $successMessage,
                'data' => [
                    'booking' => $booking->fresh(['timeSlot']),
                ],
            ]);
        }

        return back()->with('success', $successMessage);
    }
}
