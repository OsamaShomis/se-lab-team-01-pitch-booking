<?php

namespace Tests\Feature;

use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerPitchManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private User $otherOwner;
    private User $player;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create([
            'role' => 'owner',
            'email' => 'owner_test@kooraplus.com',
        ]);

        $this->otherOwner = User::factory()->create([
            'role' => 'owner',
            'email' => 'other_owner@kooraplus.com',
        ]);

        $this->player = User::factory()->create([
            'role' => 'player',
            'email' => 'player_test@kooraplus.com',
        ]);
    }

    /**
     * Test owner can view list of their own pitches.
     */
    public function test_owner_can_view_their_pitches_list(): void
    {
        Pitch::factory()->count(3)->create(['owner_id' => $this->owner->id]);
        Pitch::factory()->count(2)->create(['owner_id' => $this->otherOwner->id]);

        $response = $this->actingAs($this->owner)->get(route('owner.pitches.index'));

        $response->assertStatus(200);
        $response->assertViewIs('owner.pitches.index');
        $response->assertViewHas('pitches', function ($pitches) {
            return $pitches->count() === 3;
        });
    }

    /**
     * Test player cannot access owner pitches manager.
     */
    public function test_player_cannot_access_owner_pitches_manager(): void
    {
        $response = $this->actingAs($this->player)->get(route('owner.pitches.index'));
        $response->assertStatus(403);
    }

    /**
     * Test owner can create a new pitch and standard slots are generated.
     */
    public function test_owner_can_create_new_pitch(): void
    {
        $pitchData = [
            'name' => 'ملعب الصقر الملكي',
            'location' => 'صنعاء - عصر',
            'turf_type' => 'عشب صناعي',
            'hourly_rate' => 18000,
            'contact_phone' => '777112233',
            'description' => 'ملعب حديث مجهز بإنارة ليلية ومدرجات.',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->owner)->post(route('owner.pitches.store'), $pitchData);

        $this->assertDatabaseHas('pitches', [
            'owner_id' => $this->owner->id,
            'name' => 'ملعب الصقر الملكي',
            'hourly_rate' => 18000,
        ]);

        $newPitch = Pitch::where('name', 'ملعب الصقر الملكي')->first();
        $response->assertRedirect(route('owner.pitches.show', $newPitch));

        // Check that initial slots were created
        $this->assertGreaterThan(0, $newPitch->timeSlots()->count());
    }

    /**
     * Test owner can view and edit pitch details.
     */
    public function test_owner_can_update_pitch_details(): void
    {
        $pitch = Pitch::factory()->create(['owner_id' => $this->owner->id, 'name' => 'ملعب قديم']);

        $updateData = [
            'name' => 'ملعب النجوم المطور',
            'location' => 'صنعاء - بيت بوس',
            'turf_type' => 'عشب طبيعي',
            'hourly_rate' => 20000,
            'contact_phone' => '777998877',
            'description' => 'تم تجديد العشب بالكامل.',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->owner)->put(route('owner.pitches.update', $pitch), $updateData);

        $response->assertRedirect(route('owner.pitches.show', $pitch));

        $this->assertDatabaseHas('pitches', [
            'id' => $pitch->id,
            'name' => 'ملعب النجوم المطور',
            'hourly_rate' => 20000,
        ]);
    }

    /**
     * Test owner cannot update another owner's pitch.
     */
    public function test_owner_cannot_update_other_owners_pitch(): void
    {
        $otherPitch = Pitch::factory()->create(['owner_id' => $this->otherOwner->id]);

        $response = $this->actingAs($this->owner)->put(route('owner.pitches.update', $otherPitch), [
            'name' => 'محاولة اختراق',
            'location' => 'مكان غير مصرح به',
            'turf_type' => 'عشب صناعي',
            'hourly_rate' => 10000,
            'contact_phone' => '777000000',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test owner can generate bulk slots for future dates.
     */
    public function test_owner_can_generate_bulk_slots(): void
    {
        $pitch = Pitch::factory()->create(['owner_id' => $this->owner->id, 'hourly_rate' => 15000]);

        $startDate = Carbon::today()->addDays(5)->format('Y-m-d');
        $endDate = Carbon::today()->addDays(6)->format('Y-m-d');

        $response = $this->actingAs($this->owner)->post(route('owner.pitches.generate-slots', $pitch), [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'custom_price' => 16000,
        ]);

        $response->assertSessionHas('success');

        $slotsCount = TimeSlot::where('pitch_id', $pitch->id)
            ->whereDate('date', '>=', $startDate)
            ->count();

        $this->assertEquals(10, $slotsCount); // 5 slots/day * 2 days = 10
    }

    /**
     * Test owner can add a single custom slot and delete unbooked slot.
     */
    public function test_owner_can_add_custom_slot_and_delete_it(): void
    {
        $pitch = Pitch::factory()->create(['owner_id' => $this->owner->id]);
        $targetDate = Carbon::today()->addDays(3)->format('Y-m-d');

        // 1. Add custom slot
        $addResponse = $this->actingAs($this->owner)->post(route('owner.pitches.slots.store', $pitch), [
            'date' => $targetDate,
            'start_time' => '15:00',
            'end_time' => '16:30',
            'price' => 14000,
        ]);

        $addResponse->assertSessionHas('success');

        $slot = TimeSlot::where('pitch_id', $pitch->id)
            ->whereDate('date', $targetDate)
            ->where('start_time', '15:00:00')
            ->first();

        $this->assertNotNull($slot);
        $this->assertEquals(14000, (float)$slot->price);

        // 2. Delete the created slot
        $delResponse = $this->actingAs($this->owner)->delete(route('owner.pitches.slots.delete', ['pitch' => $pitch->id, 'slot' => $slot->id]));
        $delResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('time_slots', ['id' => $slot->id]);
    }
}
