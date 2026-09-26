<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancellationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a player can cancel their booking if it is more than 2 hours before start time (BR-03).
     */
    public function test_player_can_cancel_booking_if_more_than_two_hours_before_slot(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);

        // Slot starts tomorrow (far more than 2 hours away)
        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
            'status' => 'booked',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($player)->deleteJson("/bookings/{$booking->id}/cancel", [
            'reason' => 'ظرف طارئ لدى الفريق',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'تم إلغاء الحجز بنجاح وإعادة إتاحة الفترة الزمنية للجميع.',
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);

        // Time slot must be freed immediately
        $this->assertDatabaseHas('time_slots', [
            'id' => $slot->id,
            'status' => 'available',
        ]);
    }

    /**
     * Test cancellation is rejected if less than 2 hours remain before start time (BR-03 violation).
     */
    public function test_player_cannot_cancel_booking_if_less_than_two_hours_before_slot(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);

        // Slot starts in 1 hour (less than 120 minutes)
        $oneHourLater = Carbon::now()->addHour();
        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => $oneHourLater->format('Y-m-d'),
            'start_time' => $oneHourLater->format('H:i:s'),
            'end_time' => $oneHourLater->copy()->addHour()->format('H:i:s'),
            'status' => 'booked',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($player)->deleteJson("/bookings/{$booking->id}/cancel");

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
            'code' => 'BR_03_CANCELLATION_DEADLINE_PASSED',
        ]);

        // Booking status remains confirmed
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
        ]);

        // Slot remains booked
        $this->assertDatabaseHas('time_slots', [
            'id' => $slot->id,
            'status' => 'booked',
        ]);
    }

    /**
     * Test unauthorized user cannot cancel someone else's booking.
     */
    public function test_unauthorized_user_cannot_cancel_another_players_booking(): void
    {
        $player1 = User::factory()->create(['role' => 'player']);
        $player2 = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'status' => 'booked',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player1->id,
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
        ]);

        // Player 2 attempts to cancel Player 1's booking
        $response = $this->actingAs($player2)->deleteJson("/bookings/{$booking->id}/cancel");
        $response->assertStatus(403);
    }

    /**
     * Test cannot cancel an already cancelled booking.
     */
    public function test_cannot_cancel_already_cancelled_booking(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'status' => 'available',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $slot->id,
            'status' => 'cancelled',
        ]);

        $response = $this->actingAs($player)->deleteJson("/bookings/{$booking->id}/cancel");
        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
            'message' => 'هذا الحجز ملغي بالفعل.',
        ]);
    }

    /**
     * Test cannot cancel a completed booking.
     */
    public function test_cannot_cancel_completed_booking(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::yesterday()->format('Y-m-d'),
            'status' => 'booked',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $slot->id,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($player)->deleteJson("/bookings/{$booking->id}/cancel");
        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'error',
            'message' => 'لا يمكن إلغاء حجز مكتمل أو منتهي.',
        ]);
    }

    /**
     * Test player can view their bookings list.
     */
    public function test_player_can_view_their_bookings_list(): void
    {
        $player = User::factory()->create(['role' => 'player']);
        $owner = User::factory()->create(['role' => 'owner']);
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id, 'name' => 'ملعب الكلاسيكو']);

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $pitch->id,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '19:00:00',
            'end_time' => '20:00:00',
            'status' => 'booked',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $slot->id,
            'status' => 'confirmed',
            'booking_reference' => 'KP-TEST99',
        ]);

        $response = $this->actingAs($player)->get('/my-bookings');

        $response->assertStatus(200);
        $response->assertSee('ملعب الكلاسيكو');
        $response->assertSee('KP-TEST99');
        $response->assertSee('حجز مؤكد');
    }
}
