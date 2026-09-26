<?php

namespace App\Http\Controllers;

use App\Models\Pitch;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TimeSlotController extends Controller
{
    /**
     * Display the time-slot availability grid for a specific pitch.
     * Implements FR-03 and enforces BR-01 (preventing past date bookings).
     */
    public function index(Request $request, Pitch $pitch): View|JsonResponse|RedirectResponse
    {
        $today = Carbon::today()->toDateString();
        $selectedDate = $request->query('date', $today);

        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
            $selectedDate = $today;
        }

        // BR-01: Prevent querying or booking past dates
        if ($selectedDate < $today) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن استعراض أو حجز فترات في تاريخ سابق لليوم الحالي (BR-01).',
                    'errors' => ['date' => 'التاريخ المحدد قديم.'],
                ], 422);
            }

            return redirect()->route('pitches.slots', ['pitch' => $pitch->id, 'date' => $today])
                ->with('error', 'لا يمكن استعراض فترات في تاريخ سابق لليوم الحالي (BR-01).');
        }

        // Fetch slots for this pitch on selected date
        $slots = TimeSlot::where('pitch_id', $pitch->id)
            ->whereDate('date', $selectedDate)
            ->orderBy('start_time', 'asc')
            ->get();

        // Calculate summary counters
        $availableCount = $slots->filter(fn ($s) => $s->isAvailable() && !$s->isPast())->count();
        $bookedCount = $slots->where('status', 'booked')->count();

        // Prepare quick-select date tabs for the next 7 days
        $dateTabs = [];
        for ($i = 0; $i < 7; $i++) {
            $carbonDate = Carbon::today()->addDays($i);
            $dateString = $carbonDate->toDateString();

            $dateTabs[] = [
                'date' => $dateString,
                'is_today' => $i === 0,
                'day_name' => $this->getArabicDayName($carbonDate->dayOfWeek),
                'formatted' => $carbonDate->format('d/m'),
                'is_selected' => $dateString === $selectedDate,
            ];
        }

        // Return JSON for API or AJAX requests matching docs/API.md Endpoint 7
        if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم جلب فترات الساعات بنجاح',
                'data' => [
                    'pitch_id' => $pitch->id,
                    'pitch_name' => $pitch->name,
                    'date' => $selectedDate,
                    'available_count' => $availableCount,
                    'booked_count' => $bookedCount,
                    'slots' => $slots->map(function ($slot) {
                        return [
                            'id' => $slot->id,
                            'start_time' => substr($slot->start_time, 0, 5),
                            'end_time' => substr($slot->end_time, 0, 5),
                            'price' => (float) $slot->price,
                            'status' => $slot->status,
                            'is_available' => $slot->isAvailable() && !$slot->isPast(),
                            'is_past' => $slot->isPast(),
                        ];
                    }),
                ],
            ]);
        }

        return view('pitches.slots', compact(
            'pitch',
            'slots',
            'selectedDate',
            'dateTabs',
            'availableCount',
            'bookedCount'
        ));
    }

    /**
     * Helper to get Arabic day name.
     */
    private function getArabicDayName(int $dayOfWeek): string
    {
        return match ($dayOfWeek) {
            Carbon::SUNDAY => 'الأحد',
            Carbon::MONDAY => 'الإثنين',
            Carbon::TUESDAY => 'الثلاثاء',
            Carbon::WEDNESDAY => 'الأربعاء',
            Carbon::THURSDAY => 'الخميس',
            Carbon::FRIDAY => 'الجمعة',
            Carbon::SATURDAY => 'السبت',
            default => '',
        };
    }
}
