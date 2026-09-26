<?php

namespace Database\Seeders;

use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create an Owner User
        $owner = User::firstOrCreate(
            ['email' => 'owner@kooraplus.com'],
            [
                'name' => 'الكابتن علي الأهدل',
                'phone' => '0501234567',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        // 2. Create a Player User
        $player = User::firstOrCreate(
            ['email' => 'player@kooraplus.com'],
            [
                'name' => 'محمد الإدريسي',
                'phone' => '0507654321',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        // 3. Create Sample Pitches
        $pitchesData = [
            [
                'name' => 'ملعب الأساطير الدولي',
                'location' => 'صنعاء - حدة - بالقرب من جولة الرويشان',
                'turf_type' => 'artificial',
                'hourly_rate' => 150.00,
                'contact_phone' => '0501112233',
                'description' => 'عشب صناعي من الجيل الرابع، إضاءة ليلية عالية الكفاءة (LED)، كافتيريا، غرف تبديل ومواقف سيارات واسعة.',
                'is_active' => true,
            ],
            [
                'name' => 'ملعب ويمبلي الملكي',
                'location' => 'عدن - خور مكسر - ساحل أبين',
                'turf_type' => 'natural',
                'hourly_rate' => 200.00,
                'contact_phone' => '0502223344',
                'description' => 'عشب طبيعي فاخر بمقاسات سباعية، مدرجات للجماهير، مياه شرب ومشروبات طاقة مجانية.',
                'is_active' => true,
            ],
            [
                'name' => 'ملعب الكلاسيكو الخماسي',
                'location' => 'تعز - المسبح - الشارع العام',
                'turf_type' => 'hybrid',
                'hourly_rate' => 120.00,
                'contact_phone' => '0503334455',
                'description' => 'ملعب هجين مغلق ومجهز لكافة الظروف الجوية، كرات جديدة ومساعدات إسعافية.',
                'is_active' => true,
            ],
        ];

        // Slot schedule templates (90 minutes each):
        $slotTemplates = [
            ['start' => '16:00:00', 'end' => '17:30:00'], // عصر
            ['start' => '17:30:00', 'end' => '19:00:00'], // مغرب
            ['start' => '19:00:00', 'end' => '20:30:00'], // عشاء
            ['start' => '20:30:00', 'end' => '22:00:00'], // سهرة 1
            ['start' => '22:00:00', 'end' => '23:30:00'], // سهرة 2
        ];

        foreach ($pitchesData as $data) {
            $pitch = Pitch::firstOrCreate(
                ['name' => $data['name'], 'owner_id' => $owner->id],
                $data
            );

            // Generate slots for Today + next 6 days
            for ($dayOffset = 0; $dayOffset <= 6; $dayOffset++) {
                $currentDate = Carbon::today()->addDays($dayOffset)->toDateString();

                foreach ($slotTemplates as $index => $slot) {
                    // For demonstration: simulate that 1 slot on each day is already booked
                    $status = ($dayOffset === 0 && $index === 2) || ($dayOffset === 1 && $index === 3)
                        ? 'booked'
                        : 'available';

                    // 90 minutes price = 1.5 * hourly_rate
                    $slotPrice = $pitch->hourly_rate * 1.5;

                    TimeSlot::firstOrCreate(
                        [
                            'pitch_id' => $pitch->id,
                            'date' => $currentDate,
                            'start_time' => $slot['start'],
                        ],
                        [
                            'end_time' => $slot['end'],
                            'price' => $slotPrice,
                            'status' => $status,
                        ]
                    );
                }
            }
        }
    }
}
