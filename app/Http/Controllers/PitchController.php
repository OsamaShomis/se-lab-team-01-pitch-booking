<?php

namespace App\Http\Controllers;

use App\Models\Pitch;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PitchController extends Controller
{
    /**
     * Display a listing of sports pitches with search & filtering (FR-02).
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Pitch::where('is_active', true)->with('owner:id,name,phone');

        // 1. Text Search (Pitch Name or Description)
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // 2. City / Location Filter
        if ($location = $request->query('location')) {
            if ($location !== 'all') {
                $query->where('location', 'like', "%{$location}%");
            }
        }

        // 3. Turf Type Filter ('artificial', 'natural', 'hybrid')
        if ($turfType = $request->query('turf_type')) {
            if (in_array($turfType, ['artificial', 'natural', 'hybrid'])) {
                $query->where('turf_type', $turfType);
            }
        }

        // 4. Sorting
        $sort = $request->query('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('hourly_rate', 'asc'),
            'price_desc' => $query->orderBy('hourly_rate', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $pitches = $query->get();

        // If JSON requested (API Endpoint 5 in docs/API.md)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'تم جلب الملاعب بنجاح',
                'data' => $pitches->map(function ($pitch) {
                    return [
                        'id' => $pitch->id,
                        'name' => $pitch->name,
                        'location' => $pitch->location,
                        'turf_type' => $pitch->turf_type,
                        'hourly_rate' => (float) $pitch->hourly_rate,
                        'contact_phone' => $pitch->contact_phone,
                        'image_url' => $pitch->image_url,
                        'description' => $pitch->description,
                        'owner' => [
                            'id' => $pitch->owner?->id,
                            'name' => $pitch->owner?->name,
                        ],
                    ];
                }),
            ]);
        }

        // Predefined filter options for the UI
        $locations = [
            'صنعاء' => 'صنعاء',
            'عدن' => 'عدن',
            'تعز' => 'تعز',
            'إب' => 'إب',
            'حضرموت' => 'حضرموت',
        ];

        $turfOptions = [
            'artificial' => 'عشب صناعي (جيل رابع)',
            'natural' => 'عشب طبيعي',
            'hybrid' => 'صالة مغطاة / هجين',
        ];

        return view('pitches.index', compact('pitches', 'locations', 'turfOptions', 'search', 'location', 'turfType', 'sort'));
    }

    /**
     * Display the specified pitch details and specifications (FR-02).
     */
    public function show(Request $request, Pitch $pitch): View|JsonResponse
    {
        // Enforce active pitch
        if (!$pitch->is_active) {
            abort(404, 'الملعب المطلوب غير متوفر حالياً.');
        }

        $pitch->load('owner:id,name,phone');

        // Count today's available slots
        $today = Carbon::today()->toDateString();
        $availableSlotsCount = $pitch->timeSlots()
            ->whereDate('date', $today)
            ->where('status', 'available')
            ->count();

        // Other suggested pitches in same city or turf
        $relatedPitches = Pitch::where('is_active', true)
            ->where('id', '!=', $pitch->id)
            ->where(function ($q) use ($pitch) {
                $city = explode('—', $pitch->location)[0] ?? '';
                $city = trim(explode('-', $city)[0]);
                if (!empty($city)) {
                    $q->where('location', 'like', "%{$city}%");
                }
                $q->orWhere('turf_type', $pitch->turf_type);
            })
            ->take(3)
            ->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'تم جلب تفاصيل الملعب',
                'data' => [
                    'id' => $pitch->id,
                    'name' => $pitch->name,
                    'location' => $pitch->location,
                    'turf_type' => $pitch->turf_type,
                    'hourly_rate' => (float) $pitch->hourly_rate,
                    'contact_phone' => $pitch->contact_phone,
                    'image_url' => $pitch->image_url,
                    'description' => $pitch->description,
                    'is_active' => $pitch->is_active,
                    'available_today_slots' => $availableSlotsCount,
                    'owner' => [
                        'id' => $pitch->owner?->id,
                        'name' => $pitch->owner?->name,
                        'phone' => $pitch->owner?->phone,
                    ],
                ],
            ]);
        }

        return view('pitches.show', compact('pitch', 'availableSlotsCount', 'relatedPitches'));
    }
}
