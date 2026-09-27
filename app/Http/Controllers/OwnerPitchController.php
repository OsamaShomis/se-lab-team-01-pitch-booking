<?php

namespace App\Http\Controllers;

use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OwnerPitchController extends Controller
{
    /**
     * Display a listing of pitches belonging to the authenticated owner.
     */
    public function index(Request $request): View|JsonResponse
    {
        $user = $this->resolveOwner($request);

        $pitches = Pitch::where('owner_id', $user->id)
            ->withCount(['timeSlots', 'timeSlots as booked_slots_count' => function ($query) {
                $query->where('status', 'booked');
            }])
            ->latest()
            ->get();

        // Calculate summary metrics across all pitches
        $totalPitches = $pitches->count();
        $activePitches = $pitches->where('is_active', true)->count();
        $totalSlots = $pitches->sum('time_slots_count');
        $bookedSlots = $pitches->sum('booked_slots_count');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pitches' => $pitches,
                    'metrics' => compact('totalPitches', 'activePitches', 'totalSlots', 'bookedSlots'),
                ],
            ]);
        }

        return view('owner.pitches.index', compact('pitches', 'totalPitches', 'activePitches', 'totalSlots', 'bookedSlots', 'user'));
    }

    /**
     * Show the form for creating a new pitch.
     */
    public function create(Request $request): View
    {
        $user = $this->resolveOwner($request);
        return view('owner.pitches.create', compact('user'));
    }

    /**
     * Store a newly created pitch in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $user = $this->resolveOwner($request);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:200',
            'turf_type' => 'required|in:artificial,natural,hybrid,عشب صناعي,عشب طبيعي,عشب هجين,صالة مغطاة,ترتان',
            'hourly_rate' => 'required|numeric|min:1000|max:200000',
            'contact_phone' => 'required|string|max:20',
            'image_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        $turfType = $this->normalizeTurfType($validated['turf_type']);

        $pitch = Pitch::create([
            'owner_id' => $user->id,
            'name' => $validated['name'],
            'location' => $validated['location'],
            'turf_type' => $turfType,
            'hourly_rate' => $validated['hourly_rate'],
            'contact_phone' => $validated['contact_phone'],
            'image_url' => $validated['image_url'] ?? 'https://images.unsplash.com/photo-1529900240041-52c3ad58b021?auto=format&fit=crop&w=800&q=80',
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
        ]);

        // Automatically seed standard slots for the next 7 days for fast onboarding
        $this->generateStandardSlots($pitch, Carbon::today(), Carbon::today()->addDays(3));

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم إضافة الملعب وتوليد المواعيد الأولية بنجاح.',
                'data' => $pitch,
            ], 201);
        }

        return redirect()->route('owner.pitches.show', $pitch)->with('success', 'تم إضافة الملعب وتوليد جدول المواعيد تلقائياً بنجاح.');
    }

    /**
     * Display the specified pitch with comprehensive settings, slots, and stats.
     */
    public function show(Request $request, Pitch $pitch): View|JsonResponse
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        $selectedDate = $request->query('date', Carbon::today()->format('Y-m-d'));

        $timeSlots = $pitch->timeSlots()
            ->whereDate('date', $selectedDate)
            ->with(['booking.user'])
            ->orderBy('start_time')
            ->get();

        // Calculate pitch-specific metrics
        $allSlotsCount = $pitch->timeSlots()->count();
        $pitchBookings = $pitch->timeSlots()->whereHas('booking')->with('booking')->get()->pluck('booking');
        $totalRevenue = $pitchBookings->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $activeBookings = $pitchBookings->where('status', 'confirmed')->count();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'pitch' => $pitch,
                    'selected_date' => $selectedDate,
                    'time_slots' => $timeSlots,
                    'stats' => compact('allSlotsCount', 'totalRevenue', 'activeBookings'),
                ],
            ]);
        }

        return view('owner.pitches.show', compact('pitch', 'selectedDate', 'timeSlots', 'allSlotsCount', 'totalRevenue', 'activeBookings', 'user'));
    }

    /**
     * Show the form for editing the specified pitch.
     */
    public function edit(Request $request, Pitch $pitch): View
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        return view('owner.pitches.edit', compact('pitch', 'user'));
    }

    /**
     * Update the specified pitch in storage.
     */
    public function update(Request $request, Pitch $pitch): RedirectResponse|JsonResponse
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:200',
            'turf_type' => 'required|in:artificial,natural,hybrid,عشب صناعي,عشب طبيعي,عشب هجين,صالة مغطاة,ترتان',
            'hourly_rate' => 'required|numeric|min:1000|max:200000',
            'contact_phone' => 'required|string|max:20',
            'image_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        $turfType = $this->normalizeTurfType($validated['turf_type']);

        $pitch->update([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'turf_type' => $turfType,
            'hourly_rate' => $validated['hourly_rate'],
            'contact_phone' => $validated['contact_phone'],
            'image_url' => $validated['image_url'] ?? $pitch->image_url,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : false,
        ]);


        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم تحديث بيانات الملعب بنجاح.',
                'data' => $pitch,
            ]);
        }

        return redirect()->route('owner.pitches.show', $pitch)->with('success', 'تم حفظ وتحديث بيانات الملعب بنجاح.');
    }

    /**
     * Remove the specified pitch from storage.
     */
    public function destroy(Request $request, Pitch $pitch): RedirectResponse|JsonResponse
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        // Check if pitch has active upcoming confirmed bookings
        $hasActiveBookings = $pitch->timeSlots()
            ->whereHas('booking', function ($q) {
                $q->where('status', 'confirmed');
            })
            ->whereDate('date', '>=', Carbon::today())
            ->exists();

        if ($hasActiveBookings) {
            $msg = 'لا يمكن حذف الملعب لوجود حجوزات مؤكدة قادمة مسجلة عليه.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        DB::transaction(function () use ($pitch) {
            $pitch->timeSlots()->delete();
            $pitch->delete();
        });

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'تم حذف الملعب بنجاح.']);
        }

        return redirect()->route('owner.pitches.index')->with('success', 'تم حذف الملعب وجدول مواعيده بنجاح.');
    }

    /**
     * Generate standard 90-minute time slots for a pitch over a date range.
     */
    public function generateSlots(Request $request, Pitch $pitch): RedirectResponse|JsonResponse
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'custom_price' => 'nullable|numeric|min:1000|max:200000',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $price = $validated['custom_price'] ?? $pitch->hourly_rate;

        $createdCount = $this->generateStandardSlots($pitch, $startDate, $endDate, $price);

        $msg = "تم توليد {$createdCount} فترة زمنية جديدة بنجاح.";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg, 'count' => $createdCount]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Store a single custom time slot for a pitch.
     */
    public function storeSlot(Request $request, Pitch $pitch): RedirectResponse|JsonResponse
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'required|numeric|min:1000|max:200000',
        ]);

        // Check for duplicate slot
        $exists = $pitch->timeSlots()
            ->whereDate('date', $validated['date'])
            ->where('start_time', $validated['start_time'])
            ->exists();

        if ($exists) {
            $msg = 'توجد فترة زمنية مسجلة مسبقاً بنفس موعد البداية في هذا التاريخ.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $slot = TimeSlot::create([
            'pitch_id' => $pitch->id,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'] . ':00',
            'end_time' => $validated['end_time'] . ':00',
            'price' => $validated['price'],
            'status' => 'available',
        ]);

        $msg = 'تمت إضافة الفترة الزمنية بنجاح.';

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg, 'data' => $slot], 201);
        }

        return back()->with('success', $msg);
    }

    /**
     * Delete an unbooked time slot.
     */
    public function deleteSlot(Request $request, Pitch $pitch, TimeSlot $slot): RedirectResponse|JsonResponse
    {
        $user = $this->resolveOwner($request);
        $this->authorizePitch($user, $pitch);

        if ($slot->pitch_id !== $pitch->id) {
            abort(404, 'الفترة الزمنية غير تابعة لهذا الملعب.');
        }

        if ($slot->status === 'booked' || $slot->booking) {
            $msg = 'لا يمكن حذف فترة زمنية محجوزة. يجب إلغاء الحجز أولاً.';
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $slot->delete();

        $msg = 'تم حذف الفترة الزمنية بنجاح.';

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Helper to resolve owner or mock during local dev.
     */
    private function resolveOwner(Request $request): User
    {
        $user = $request->user();

        if (!$user && app()->environment('local') && !app()->runningUnitTests()) {
            $user = User::where('role', 'owner')->first();
            if ($user) {
                auth()->login($user);
            }
        }

        if (!$user || !$user->isOwner()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة تحكم أصحاب الملاعب.');
        }

        return $user;
    }

    /**
     * Helper to authorize that pitch belongs to owner.
     */
    private function authorizePitch(User $user, Pitch $pitch): void
    {
        if ($pitch->owner_id !== $user->id) {
            abort(403, 'لا تملك صلاحية الوصول أو التعديل على هذا الملعب.');
        }
    }

    /**
     * Helper to generate 90-min standard slots.
     */
    private function generateStandardSlots(Pitch $pitch, Carbon $start, Carbon $end, ?float $customPrice = null): int
    {
        $price = $customPrice ?? $pitch->hourly_rate;
        $intervals = [
            ['16:00:00', '17:30:00'],
            ['17:30:00', '19:00:00'],
            ['19:00:00', '20:30:00'],
            ['20:30:00', '22:00:00'],
            ['22:00:00', '23:30:00'],
        ];

        $created = 0;
        $curr = $start->copy();

        while ($curr->lte($end)) {
            $dateStr = $curr->format('Y-m-d');
            foreach ($intervals as $pair) {
                $exists = TimeSlot::where('pitch_id', $pitch->id)
                    ->whereDate('date', $dateStr)
                    ->where('start_time', $pair[0])
                    ->exists();

                if (!$exists) {
                    TimeSlot::create([
                        'pitch_id' => $pitch->id,
                        'date' => $dateStr,
                        'start_time' => $pair[0],
                        'end_time' => $pair[1],
                        'price' => $price,
                        'status' => 'available',
                    ]);
                    $created++;
                }
            }
            $curr->addDay();
        }

        return $created;
    }

    /**
     * Helper to normalize turf type values to database enum.
     */
    private function normalizeTurfType(string $input): string
    {
        return match ($input) {
            'natural', 'عشب طبيعي' => 'natural',
            'hybrid', 'عشب هجين' => 'hybrid',
            default => 'artificial',
        };
    }
}


