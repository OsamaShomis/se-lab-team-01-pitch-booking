<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ButtonsAndInteractionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. Test Homepage buttons depending on user role.
     */
    public function test_homepage_buttons_for_guest_and_player_and_owner(): void
    {
        // A) Guest on homepage
        $guestResponse = $this->get('/');
        $guestResponse->assertStatus(200);
        $guestResponse->assertSee('استعراض وحجز الملاعب المتاحة');
        $guestResponse->assertSee('إنشاء حساب لاعب');
        $guestResponse->assertSee('تسجيل منشأة رياضية');

        // B) Logged-in Player on homepage
        $player = User::factory()->create(['name' => 'محمد الإدريسي', 'role' => 'player']);
        $playerResponse = $this->actingAs($player)->get('/');
        $playerResponse->assertStatus(200);
        $playerResponse->assertSee('استعراض وحجز الملاعب المتاحة');
        $playerResponse->assertSee('سجل حجوزاتي المؤكدة');
        $playerResponse->assertSee('حجوزاتي');
        $playerResponse->assertSee('محمد الإدريسي');

        // C) Logged-in Owner visiting homepage is redirected to dashboard
        $owner = User::factory()->create(['role' => 'owner']);
        $ownerResponse = $this->actingAs($owner)->get('/');
        $ownerResponse->assertRedirect(route('owner.dashboard'));
    }

    /**
     * 2. Test Navbar items and buttons across all 3 roles.
     */
    public function test_navbar_navigation_and_buttons_role_segregation(): void
    {
        // Guest Navbar
        $guestResp = $this->get('/pitches');
        $guestResp->assertStatus(200);
        $guestResp->assertSee('الرئيسية');
        $guestResp->assertSee('استعراض الملاعب');
        $guestResp->assertSee('تسجيل الدخول');
        $guestResp->assertSee('إنشاء حساب');
        $guestResp->assertDontSee('جدول الساعات');
        $guestResp->assertDontSee('حجوزاتي');
        $guestResp->assertDontSee('لوحة التحكم');

        // Player Navbar
        $player = User::factory()->create(['role' => 'player']);
        $playerResp = $this->actingAs($player)->get('/pitches');
        $playerResp->assertStatus(200);
        $playerResp->assertSee('حجوزاتي');
        $playerResp->assertSee('خروج');
        $playerResp->assertDontSee('لوحة التحكم');
        $playerResp->assertDontSee('إدارة ملاعبي');
        $playerResp->assertDontSee('جدول الساعات');

        // Owner Navbar
        $owner = User::factory()->create(['role' => 'owner']);
        $ownerResp = $this->actingAs($owner)->get('/owner/dashboard');
        $ownerResp->assertStatus(200);
        $ownerResp->assertSee('لوحة التحكم');
        $ownerResp->assertSee('إدارة ملاعبي');
        $ownerResp->assertSee('إضافة ملعب جديد');
        $ownerResp->assertSee('خروج');
        $ownerResp->assertDontSee('حجوزاتي');
        $ownerResp->assertDontSee('جدول الساعات');
    }

    /**
     * 3. Test Pitches catalog filters and details buttons.
     */
    public function test_pitches_catalog_search_filters_and_detail_buttons(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch1 = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب النجوم الذهبية',
            'location' => 'صنعاء - حدة',
            'turf_type' => 'natural',
            'hourly_rate' => 12000,
            'is_active' => true,
        ]);

        $pitch2 = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب الكلاسيكو الساحلي',
            'location' => 'المكلا',
            'turf_type' => 'artificial',
            'hourly_rate' => 10000,
            'is_active' => true,
        ]);

        // Filter button test: Search by name
        $searchResp = $this->get('/pitches?search=النجوم');
        $searchResp->assertStatus(200);
        $searchResp->assertSee('ملعب النجوم الذهبية');
        $searchResp->assertDontSee('ملعب الكلاسيكو الساحلي');

        // Filter button test: Filter by turf
        $turfResp = $this->get('/pitches?turf_type=artificial');
        $turfResp->assertStatus(200);
        $turfResp->assertSee('ملعب الكلاسيكو الساحلي');

        // Button link to Pitch details
        $detailResp = $this->get(route('pitches.show', $pitch1->id));
        $detailResp->assertStatus(200);
        $detailResp->assertSee('ملعب النجوم الذهبية');
        $detailResp->assertSee('عرض جدول الساعات والحجز');
    }

    /**
     * 4. Test Pitch Details booking modal submission button.
     */
    public function test_booking_submission_button(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id, 'hourly_rate' => 15000]);

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '19:00:00',
            'end_time' => '20:30:00',
            'price' => 15000,
            'status' => 'available',
        ]);

        // Post booking (simulates clicking the "تأكيد الحجز الفوري" button)
        $response = $this->actingAs($player)->post(route('bookings.store'), [
            'time_slot_id' => $slot->id,
            'notes' => 'فريق شباب الكرامة',
        ]);

        $response->assertRedirect(route('bookings.my'));
        $this->assertDatabaseHas('bookings', [
            'user_id' => $player->id,
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);
        $this->assertDatabaseHas('time_slots', [
            'id' => $slot->id,
            'status' => 'booked',
        ]);
    }

    /**
     * 5. Test My Bookings page buttons (Tabs, Details Modal trigger, and Cancellation Button).
     */
    public function test_my_bookings_buttons_and_cancellation_button(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id, 'name' => 'ملعب الفتح', 'hourly_rate' => 10000]);

        // Eligible booking for cancellation (> 2 hours away)
        $slot1 = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '18:00:00',
            'end_time' => '19:30:00',
            'status' => 'booked',
        ]);

        $booking1 = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $slot1->id,
            'booking_reference' => 'KP-TEST-001',
            'status' => 'confirmed',
            'total_price' => 10000,
        ]);

        $response = $this->actingAs($player)->get(route('bookings.my'));
        $response->assertStatus(200);

        // Verify Tab buttons exist
        $response->assertSee('كافة الحجوزات');
        $response->assertSee('المؤكدة');
        $response->assertSee('المكتملة');
        $response->assertSee('الملغاة');

        // Verify Details Modal button exists
        $response->assertSee('تفاصيل الحجز');
        $response->assertSee('KP-TEST-001');
        $response->assertSee('ملعب الفتح');

        // Verify Cancellation button exists with correct action
        $response->assertSee(route('bookings.cancel', $booking1->id));
        $response->assertSee('إلغاء الحجز');

        // Simulate clicking "إلغاء الحجز" web button
        $cancelResponse = $this->actingAs($player)->delete(route('bookings.cancel', $booking1->id));
        $cancelResponse->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking1->id,
            'status' => 'cancelled',
        ]);
    }

    /**
     * 6. Test Owner Pitch management buttons (Create, Edit with Image, Show, Delete).
     */
    public function test_owner_pitch_crud_buttons_and_image_upload(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        // A) Create pitch button submission with image file
        $file = UploadedFile::fake()->image('my_pitch.jpg', 600, 400);

        $createResponse = $this->actingAs($owner)->post(route('owner.pitches.store'), [
            'name' => 'ملعب الأبطال الدولي',
            'location' => 'صنعاء - السبعين',
            'turf_type' => 'natural',
            'hourly_rate' => 12000,
            'contact_phone' => '777123456',
            'description' => 'ملعب حديث ومجهز بالكامل',
            'is_active' => '1',
            'image' => $file,
        ]);

        $createResponse->assertRedirect();
        $this->assertDatabaseHas('pitches', [
            'name' => 'ملعب الأبطال الدولي',
            'owner_id' => $owner->id,
        ]);

        $createdPitch = Pitch::where('name', 'ملعب الأبطال الدولي')->first();
        $this->assertNotNull($createdPitch);
        $this->assertStringContainsString('images/pitches/', $createdPitch->image_url);

        // Clean up test file
        $publicFilePath = public_path($createdPitch->image_url);
        if (file_exists($publicFilePath)) {
            @unlink($publicFilePath);
        }

        // B) Edit pitch button submission
        $editResponse = $this->actingAs($owner)->put(route('owner.pitches.update', $createdPitch->id), [
            'name' => 'ملعب الأبطال الذهبي المعدل',
            'location' => 'صنعاء - السبعين',
            'turf_type' => 'natural',
            'hourly_rate' => 14000,
            'contact_phone' => '777123456',
            'description' => 'تعديل الوصف بنجاح',
            'is_active' => '1',
        ]);

        $editResponse->assertRedirect(route('owner.pitches.show', $createdPitch->id));
        $this->assertDatabaseHas('pitches', [
            'id' => $createdPitch->id,
            'name' => 'ملعب الأبطال الذهبي المعدل',
            'hourly_rate' => 14000,
        ]);

        // C) Generate slots button in Pitch Control Room
        $genResponse = $this->actingAs($owner)->post(route('owner.pitches.generate-slots', $createdPitch->id), [
            'start_date' => Carbon::tomorrow()->format('Y-m-d'),
            'days' => 2,
        ]);
        $genResponse->assertRedirect();
        $this->assertTrue(TimeSlot::where('pitch_id', $createdPitch->id)->count() > 0);

        // D) Delete pitch button
        $deleteResponse = $this->actingAs($owner)->delete(route('owner.pitches.destroy', $createdPitch->id));
        $deleteResponse->assertRedirect(route('owner.pitches.index'));
        $this->assertDatabaseMissing('pitches', [
            'id' => $createdPitch->id,
        ]);
    }
}
