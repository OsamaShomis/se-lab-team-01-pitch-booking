<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Pitch Owners
        $owner1 = User::firstOrCreate(
            ['email' => 'owner@kooraplus.com'],
            [
                'name' => 'الكابتن صالح الشميري',
                'phone' => '777123456',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );
        $owner = $owner1;

        $owner2 = User::firstOrCreate(
            ['email' => 'owner2@kooraplus.com'],
            [
                'name' => 'الكابتن فهد المقطري',
                'phone' => '771987654',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        // 2. Create Players
        $player1 = User::firstOrCreate(
            ['email' => 'player1@kooraplus.com'],
            [
                'name' => 'أحمد المهاجم',
                'phone' => '773112233',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        $player2 = User::firstOrCreate(
            ['email' => 'player2@kooraplus.com'],
            [
                'name' => 'عمر صانع الألعاب',
                'phone' => '775445566',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        $player3 = User::firstOrCreate(
            ['email' => 'player3@kooraplus.com'],
            [
                'name' => 'ياسر الكابتن',
                'phone' => '779889900',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        // 3. Create Pitches
        $pitch1 = Pitch::firstOrCreate(
            ['name' => 'ملعب الأساطير الدولي'],
            [
                'owner_id' => $owner1->id,
                'location' => 'صنعاء — حي حدة خلف مجمع الكميم',
                'turf_type' => 'artificial',
                'hourly_rate' => 12000.00,
                'contact_phone' => '777123456',
                'description' => 'ملعب سباعي مجهز بأحدث كشافات الإنارة الليلية، مواقف سيارات خاصة، وغرف تبديل ملابس واستراحة مكيفة.',
                'is_active' => true,
            ]
        );

        $pitch2 = Pitch::firstOrCreate(
            ['name' => 'ملعب قمة النجوم'],
            [
                'owner_id' => $owner1->id,
                'location' => 'صنعاء — شارع الستين الغربي جوار جسر مذبح',
                'turf_type' => 'artificial',
                'hourly_rate' => 10000.00,
                'contact_phone' => '777123456',
                'description' => 'ملعب خماسي متميز، كافيه ومشروبات، أرضية معشبة حديثة وشباك حماية.',
                'is_active' => true,
            ]
        );

        // 4. Create Today's Time Slots for Pitch 1
        $today = Carbon::today()->format('Y-m-d');

        $slotsData = [
            ['start' => '16:00:00', 'end' => '17:00:00', 'status' => 'booked', 'booked_by' => $player1, 'b_status' => 'completed'],
            ['start' => '17:00:00', 'end' => '18:00:00', 'status' => 'booked', 'booked_by' => $player2, 'b_status' => 'confirmed'],
            ['start' => '18:00:00', 'end' => '19:00:00', 'status' => 'available', 'booked_by' => null, 'b_status' => null],
            ['start' => '19:00:00', 'end' => '20:00:00', 'status' => 'booked', 'booked_by' => $player3, 'b_status' => 'confirmed'],
            ['start' => '20:00:00', 'end' => '21:00:00', 'status' => 'available', 'booked_by' => null, 'b_status' => null],
            ['start' => '21:00:00', 'end' => '22:00:00', 'status' => 'available', 'booked_by' => null, 'b_status' => null],
            ['start' => '22:00:00', 'end' => '23:00:00', 'status' => 'available', 'booked_by' => null, 'b_status' => null],
        ];

        foreach ($slotsData as $index => $slotInfo) {
            $slot = TimeSlot::firstOrCreate(
                [
                    'pitch_id' => $pitch1->id,
                    'date' => $today,
                    'start_time' => $slotInfo['start'],
                ],
                [
                    'end_time' => $slotInfo['end'],
                    'price' => $pitch1->hourly_rate,
                    'status' => $slotInfo['status'],
                ]
            );

            if ($slotInfo['booked_by']) {
                Booking::firstOrCreate(
                    ['time_slot_id' => $slot->id],
                    [
                        'booking_reference' => 'KP-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                        'user_id' => $slotInfo['booked_by']->id,
                        'total_price' => $pitch1->hourly_rate,
                        'status' => $slotInfo['b_status'],
                        'notes' => 'حجز تجريبي مباشر من منصة كورة بلص',
                    ]
                );
            }
        }

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

        // 3. Create Additional Sample Pitches
        $pitchesData = [
            [
                'name' => 'ملعب النخبة الأولمبي',
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
