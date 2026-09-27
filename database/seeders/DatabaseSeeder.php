<?php

namespace Database\Seeders;

use App\Models\Booking;
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
        // 1. Create Pitch Owners
        $owner1 = User::firstOrCreate(
            ['email' => 'owner@kooraplus.com'],
            [
                'name' => 'الكابتن علي الأهدل',
                'phone' => '777123456',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        $owner2 = User::firstOrCreate(
            ['email' => 'owner2@kooraplus.com'],
            [
                'name' => 'الكابتن فهد المقطري',
                'phone' => '777987654',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        $owner3 = User::firstOrCreate(
            ['email' => 'owner3@kooraplus.com'],
            [
                'name' => 'الكابتن وضاح الحضرمي',
                'phone' => '777456789',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        // 2. Create Players
        $player1 = User::firstOrCreate(
            ['email' => 'player@kooraplus.com'],
            [
                'name' => 'محمد الإدريسي',
                'phone' => '771234567',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        $player2 = User::firstOrCreate(
            ['email' => 'player2@kooraplus.com'],
            [
                'name' => 'عمر صانع الألعاب',
                'phone' => '772345678',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        $player3 = User::firstOrCreate(
            ['email' => 'player3@kooraplus.com'],
            [
                'name' => 'ياسر الهداف',
                'phone' => '773456789',
                'password' => Hash::make('password123'),
                'role' => 'player',
            ]
        );

        // 3. Create Pitches (8 diverse pitches mapped to real images)
        $pitchesData = [
            [
                'owner_id' => $owner1->id,
                'name' => 'ملعب الأساطير الدولي',
                'location' => 'صنعاء — حي حدة خلف مجمع الكميم',
                'turf_type' => 'artificial',
                'hourly_rate' => 12000.00,
                'contact_phone' => '777123456',
                'image_url' => 'images/pitch1.jpg',
                'description' => 'ملعب سباعي فاخر معشب بأحدث عشب صناعي من الجيل الرابع (FIFA Standard). مجهز بكشافات LED ليلية فائقة الإضاءة، مدرج للجماهير، غرف تبديل ملابس واستراحة مكيفة، ومواقف سيارات آمنة.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner1->id,
                'name' => 'ملعب قمة النجوم',
                'location' => 'صنعاء — شارع الستين الغربي جوار جسر مذبح',
                'turf_type' => 'artificial',
                'hourly_rate' => 9500.00,
                'contact_phone' => '777123456',
                'image_url' => 'images/pitch2.jpg',
                'description' => 'ملعب خماسي عصري ذو أرضية عشبية ممتازة وشباك حماية كاملة. يحتوي على كافتيريا متكاملة لتقديم المشروبات ومعدات رياضية وتأجير سترات تدريب.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner2->id,
                'name' => 'ملعب الكلاسيكو الملكي',
                'location' => 'عدن — خور مكسر بالقرب من ساحل أبين',
                'turf_type' => 'natural',
                'hourly_rate' => 15000.00,
                'contact_phone' => '777987654',
                'image_url' => 'images/pitch3.jpg',
                'description' => 'ملعب ثماني مميز بأرضية عشب طبيعي معتنى بها بعناية فائقة. إطلالة بحرية نقية، كشافات احترافية، مياه شرب ومشروبات طاقة مجانية للفرق.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner2->id,
                'name' => 'صالة المسبح الرياضية المغطاة',
                'location' => 'تعز — المسبح شارع جمال',
                'turf_type' => 'hybrid',
                'hourly_rate' => 11000.00,
                'contact_phone' => '777987654',
                'image_url' => 'images/pitch4.jpg',
                'description' => 'صالة هجينة مغلقة ومكيفة تتسع لـ 6 ضد 6، أرضية باركيه رياضية احترافية، مناسبة لكافة الظروف الجوية واللعب المسائي، وخدمات إسعافية.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner3->id,
                'name' => 'ملعب اللواء الأولمبي',
                'location' => 'إب — الدائري الغربي جوار منتزه مشورة',
                'turf_type' => 'natural',
                'hourly_rate' => 10500.00,
                'contact_phone' => '777456789',
                'image_url' => 'images/pitch5.jpg',
                'description' => 'ملعب طبيعي خلاب بين أحضان الطبيعة في إب الخضراء. مقاسات واسعة لـ 7 ضد 7، حكام ومراقبين معتمدين، ومواقف شاسعة للحافلات والسيارات.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner3->id,
                'name' => 'ملعب شاطئ المكلا الساحلي',
                'location' => 'حضرموت — المكلا حي الشرج',
                'turf_type' => 'artificial',
                'hourly_rate' => 8500.00,
                'contact_phone' => '777456789',
                'image_url' => 'images/pitch6.jpg',
                'description' => 'ملعب حديث ومعشب صناعياً بمواصفات ممتازة، كرات جديدة مع كل مباراة، غرف استحمام، وقريب جداً من قلب مدينة المكلا والخدمات العامة.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner1->id,
                'name' => 'ملعب السبعين الدولي',
                'location' => 'صنعاء — ميدان السبعين',
                'turf_type' => 'artificial',
                'hourly_rate' => 13500.00,
                'contact_phone' => '777123456',
                'image_url' => 'images/pitch7.jpg',
                'description' => 'ملعب متكامل بمقاسات دولية عشب صناعي جيل رابع، مدرجات، إنارة ليلية وتصوير مباريات.',
                'is_active' => true,
            ],
            [
                'owner_id' => $owner2->id,
                'name' => 'ملعب الفرسان الرياضي',
                'location' => 'عدن — المعلا الشارع الرئيسي',
                'turf_type' => 'hybrid',
                'hourly_rate' => 12500.00,
                'contact_phone' => '777987654',
                'image_url' => 'images/pitch8.jpg',
                'description' => 'أرضية ممتازة هجينة، تهوية ممتازة، كافتيريا وغرف تبديل واستراحة مجهزة بالكامل.',
                'is_active' => true,
            ],
        ];

        // Slot Templates (90 minutes match standard)
        $slotTemplates = [
            ['start' => '16:00:00', 'end' => '17:30:00'], // عصر
            ['start' => '17:30:00', 'end' => '19:00:00'], // مغرب
            ['start' => '19:00:00', 'end' => '20:30:00'], // عشاء
            ['start' => '20:30:00', 'end' => '22:00:00'], // سهرة 1
            ['start' => '22:00:00', 'end' => '23:30:00'], // سهرة 2
        ];

        $today = Carbon::today()->toDateString();

        foreach ($pitchesData as $pIndex => $pData) {
            $pitch = Pitch::firstOrCreate(
                ['name' => $pData['name']],
                $pData
            );

            // Generate slots for Today + next 6 days
            for ($dayOffset = 0; $dayOffset <= 6; $dayOffset++) {
                $currentDate = Carbon::today()->addDays($dayOffset)->toDateString();

                foreach ($slotTemplates as $sIndex => $slot) {
                    // Simulate booked slots for realistic interactive experience
                    $isBooked = ($dayOffset === 0 && in_array($sIndex, [1, 3])) || ($dayOffset === 1 && $sIndex === 2);
                    $status = $isBooked ? 'booked' : 'available';

                    // 90 minutes slot price
                    $slotPrice = $pitch->hourly_rate * 1.5;

                    $timeSlot = TimeSlot::firstOrCreate(
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

                    // Create real bookings for booked slots
                    if ($isBooked) {
                        $bookedPlayer = match($sIndex) {
                            1 => $player1,
                            2 => $player2,
                            default => $player3,
                        };

                        Booking::firstOrCreate(
                            ['time_slot_id' => $timeSlot->id],
                            [
                                'booking_reference' => 'KP-' . strtoupper(substr(md5($timeSlot->id . $currentDate), 0, 6)),
                                'user_id' => $bookedPlayer->id,
                                'total_price' => $slotPrice,
                                'status' => 'confirmed',
                                'notes' => 'حجز تجريبي مباشر من منصة كورة بلص',
                            ]
                        );
                    }
                }
            }
        }
    }
}
