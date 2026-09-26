<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_roles_and_helpers(): void
    {
        $owner = User::factory()->owner()->create();
        $player = User::factory()->player()->create();

        $this->assertTrue($owner->isOwner());
        $this->assertFalse($owner->isPlayer());

        $this->assertTrue($player->isPlayer());
        $this->assertFalse($player->isOwner());
    }

    public function test_pitch_belongs_to_owner_and_has_time_slots(): void
    {
        $owner = User::factory()->owner()->create();
        $pitch = Pitch::factory()->create(['owner_id' => $owner->id]);
        $slot = TimeSlot::factory()->create(['pitch_id' => $pitch->id]);

        $this->assertEquals($owner->id, $pitch->owner->id);
        $this->assertCount(1, $pitch->timeSlots);
        $this->assertEquals($pitch->id, $slot->pitch->id);
    }

    public function test_time_slot_helpers(): void
    {
        $futureSlot = TimeSlot::factory()->create([
            'date' => now()->addDays(2)->format('Y-m-d'),
            'start_time' => '18:00:00',
            'status' => 'available',
        ]);

        $this->assertTrue($futureSlot->isAvailable());
        $this->assertFalse($futureSlot->isPast());

        $pastSlot = TimeSlot::factory()->create([
            'date' => now()->subDays(2)->format('Y-m-d'),
            'start_time' => '10:00:00',
            'status' => 'available',
        ]);

        $this->assertTrue($pastSlot->isPast());
    }

    public function test_booking_relationships_and_cancellation_rule_br03(): void
    {
        $player = User::factory()->player()->create();
        
        // Slot is 5 hours in future (cancellation allowed: > 2 hours)
        $futureSlot = TimeSlot::factory()->create([
            'date' => now()->addDays(1)->format('Y-m-d'),
            'start_time' => '20:00:00',
            'status' => 'booked',
        ]);

        $booking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $futureSlot->id,
            'status' => 'confirmed',
        ]);

        $this->assertEquals($player->id, $booking->user->id);
        $this->assertEquals($futureSlot->id, $booking->timeSlot->id);
        $this->assertTrue($booking->canBeCancelled());

        // Slot is 30 minutes in future (cancellation forbidden: < 2 hours)
        $imminentSlot = TimeSlot::factory()->create([
            'date' => now()->format('Y-m-d'),
            'start_time' => now()->addMinutes(30)->format('H:i:s'),
            'status' => 'booked',
        ]);

        $imminentBooking = Booking::factory()->create([
            'user_id' => $player->id,
            'time_slot_id' => $imminentSlot->id,
            'status' => 'confirmed',
        ]);

        $this->assertFalse($imminentBooking->canBeCancelled());
    }
}
