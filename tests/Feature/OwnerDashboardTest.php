<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test unauthenticated user or regular player cannot access the owner dashboard.
     */
    public function test_unauthenticated_or_player_cannot_access_owner_dashboard(): void
    {
        // 1. Unauthenticated guest (either rejected with 403 or redirected to login with 302)
        $response = $this->get('/owner/dashboard');
        $this->assertTrue(in_array($response->status(), [403, 302]));

        // 2. Regular player user
        $player = User::factory()->create(['role' => 'player']);
        $response = $this->actingAs($player)->get('/owner/dashboard');
        $response->assertStatus(403);
    }

    /**
     * Test owner can view dashboard with their pitches and daily schedule.
     */
    public function test_owner_can_view_dashboard_with_their_pitches(): void
    {
        $owner = User::factory()->create(['role' => 'owner', 'name' => 'الكابتن علي']);
        $pitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب النجوم الدولي',
        ]);

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::today()->format('Y-m-d'),
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
            'status' => 'booked',
        ]);

        $player = User::factory()->create(['role' => 'player', 'name' => 'أحمد الهداف']);
        $booking = Booking::factory()->create([
            'time_slot_id' => $slot->id,
            'user_id' => $player->id,
            'status' => 'confirmed',
            'total_price' => 150.00,
        ]);

        $response = $this->actingAs($owner)->get('/owner/dashboard');

        $response->assertStatus(200);
        $response->assertSee('ملعب النجوم الدولي');
        $response->assertSee('الكابتن علي');
        $response->assertSee('أحمد الهداف');
        $response->assertSee('18:00');
    }

    /**
     * Test owner cannot access or view another owner's pitch schedule.
     */
    public function test_owner_cannot_view_another_owners_pitch(): void
    {
        $owner1 = User::factory()->create(['role' => 'owner']);
        $owner2 = User::factory()->create(['role' => 'owner']);

        $pitch2 = Pitch::factory()->create(['owner_id' => $owner2->id]);

        $response = $this->actingAs($owner1)->get("/owner/dashboard?pitch_id={$pitch2->id}");
        $response->assertStatus(403);
    }

    /**
     * Test owner can filter schedule by date.
     */
    public function test_owner_can_filter_schedule_by_date(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);

        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => $tomorrow,
            'start_time' => '20:00:00',
            'end_time' => '21:00:00',
            'status' => 'available',
        ]);

        $response = $this->actingAs($owner)->get("/owner/dashboard?pitch_id={$pitch->id}&date={$tomorrow}");

        $response->assertStatus(200);
        $response->assertSee('20:00');
    }

    /**
     * Test owner can update booking status to completed.
     */
    public function test_owner_can_mark_booking_as_completed(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);
        $slot = TimeSlot::factory()->create(['pitch_id' => $pitch->id, 'status' => 'booked']);
        $booking = Booking::factory()->create([
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($owner)->patchJson("/owner/bookings/{$booking->id}/status", [
            'status' => 'completed',
            'notes' => 'حضر الفريق ولعب المباراة كاملة',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'completed',
            'notes' => 'حضر الفريق ولعب المباراة كاملة',
        ]);
    }

    /**
     * Test owner cancelling booking frees up the time slot.
     */
    public function test_owner_cancelling_booking_frees_time_slot(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);
        $slot = TimeSlot::factory()->create(['pitch_id' => $pitch->id, 'status' => 'booked']);
        $booking = Booking::factory()->create([
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($owner)->patchJson("/owner/bookings/{$booking->id}/status", [
            'status' => 'cancelled',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);

        // Verify slot is now available
        $this->assertDatabaseHas('time_slots', [
            'id' => $slot->id,
            'status' => 'available',
        ]);
    }
}
