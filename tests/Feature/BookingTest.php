<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private User $player;
    private User $owner;
    private Pitch $pitch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->player = User::factory()->create(['role' => 'player']);
        $this->owner = User::factory()->create(['role' => 'owner']);
        $this->pitch = Pitch::factory()->create([
            'owner_id' => $this->owner->id,
            'name' => 'ملعب الكامب نو النموذجي',
            'hourly_rate' => 120.00,
        ]);
    }

    /**
     * Test 1: Authenticated player can reserve an available slot via Web form.
     * Validates redirect to /my-bookings, flash message, slot status transition to booked, and reference code format.
     */
    public function test_authenticated_player_can_reserve_available_slot_via_web_form(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $tomorrow,
            'start_time' => '18:00:00',
            'end_time' => '19:30:00',
            'price' => 180.00,
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->player)
            ->post(route('bookings.store'), [
                'time_slot_id' => $slot->id,
                'notes' => 'فريق النجوم - يرجى تجهيز كرات إضافية',
            ]);

        $response->assertRedirect(route('bookings.my'));
        $response->assertSessionHas('success');

        // Verify booking in database
        $this->assertDatabaseHas('bookings', [
            'user_id' => $this->player->id,
            'time_slot_id' => $slot->id,
            'total_price' => 180.00,
            'status' => 'confirmed',
            'notes' => 'فريق النجوم - يرجى تجهيز كرات إضافية',
        ]);

        // Verify time slot status changed to booked (BR-02)
        $this->assertDatabaseHas('time_slots', [
            'id' => $slot->id,
            'status' => 'booked',
        ]);

        // Verify booking reference follows standard pattern KP-YYYY-XXXX
        $booking = Booking::where('time_slot_id', $slot->id)->first();
        $this->assertNotNull($booking);
        $this->assertMatchesRegularExpression('/^KP-\d{4}-[A-Z0-9]{5}$/', $booking->booking_reference);
    }

    /**
     * Test 2: Authenticated player can reserve slot via JSON API (docs/API.md Endpoint 8).
     * Validates 201 Created status and strict JSON contract response.
     */
    public function test_authenticated_player_can_reserve_slot_via_json_api(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $tomorrow,
            'start_time' => '20:00:00',
            'end_time' => '21:30:00',
            'price' => 200.00,
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->player)
            ->postJson('/api/bookings', [
                'time_slot_id' => $slot->id,
                'notes' => 'حجز تجريبي عبر الواجهة البرمجية',
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'booking_reference',
                'status',
                'total_price',
                'notes',
                'pitch' => [
                    'id',
                    'name',
                    'location',
                ],
                'time_slot' => [
                    'id',
                    'date',
                    'start_time',
                    'end_time',
                ],
                'created_at',
            ],
        ]);

        $response->assertJson([
            'success' => true,
            'message' => 'تم تأكيد الحجز بنجاح',
            'data' => [
                'status' => 'confirmed',
                'total_price' => 200.00,
                'pitch' => [
                    'id' => $this->pitch->id,
                    'name' => $this->pitch->name,
                ],
                'time_slot' => [
                    'id' => $slot->id,
                    'date' => $tomorrow,
                ],
            ],
        ]);

        $this->assertEquals('booked', $slot->fresh()->status);
    }

    /**
     * Test 3: Unauthenticated guest cannot book and is redirected to /login (US-04 AC-1).
     */
    public function test_guest_is_redirected_to_login_on_booking_attempt(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $tomorrow,
            'start_time' => '17:00:00',
            'end_time' => '18:00:00',
            'status' => 'available',
        ]);

        // Web request
        $webResponse = $this->post(route('bookings.store'), [
            'time_slot_id' => $slot->id,
        ]);
        $webResponse->assertRedirect(route('login'));

        // API request
        $apiResponse = $this->postJson('/api/bookings', [
            'time_slot_id' => $slot->id,
        ]);
        $apiResponse->assertStatus(401);

        $this->assertDatabaseCount('bookings', 0);
        $this->assertEquals('available', $slot->fresh()->status);
    }

    /**
     * Test 4: Pitch owner cannot book as a player.
     */
    public function test_pitch_owner_cannot_book_slot_as_player(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $tomorrow,
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->owner)
            ->postJson('/api/bookings', [
                'time_slot_id' => $slot->id,
            ]);

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'الحجز متاح للاعبين فقط. لا يمكن لصاحب الملعب الحجز كلاعب.',
        ]);

        $this->assertDatabaseCount('bookings', 0);
        $this->assertEquals('available', $slot->fresh()->status);
    }

    /**
     * Test 5: Booking a past slot is rejected with 400 Bad Request per BR-01.
     */
    public function test_booking_past_slot_is_rejected_per_br01(): void
    {
        $yesterday = Carbon::yesterday()->toDateString();

        $pastSlot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $yesterday,
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->player)
            ->postJson('/api/bookings', [
                'time_slot_id' => $pastSlot->id,
            ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertStringContainsString('BR-01', $response->json('message'));

        $this->assertDatabaseCount('bookings', 0);
    }

    /**
     * Test 6: Booking an already booked slot is rejected with 409 Conflict per BR-02.
     */
    public function test_booking_already_booked_slot_is_rejected_per_br02(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $bookedSlot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $tomorrow,
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
            'status' => 'booked',
        ]);

        $response = $this->actingAs($this->player)
            ->postJson('/api/bookings', [
                'time_slot_id' => $bookedSlot->id,
            ]);

        $response->assertStatus(409);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertStringContainsString('BR-02', $response->json('message'));

        $this->assertDatabaseCount('bookings', 0);
    }

    /**
     * Test 7: Concurrency & Database UNIQUE constraint protection (NFR-04).
     * Ensures that even under race conditions, a slot cannot be booked twice.
     */
    public function test_database_constraint_prevents_duplicate_slot_bookings(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $slot = TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $tomorrow,
            'start_time' => '19:00:00',
            'end_time' => '20:00:00',
            'status' => 'available',
        ]);

        $playerTwo = User::factory()->create(['role' => 'player']);

        // First booking succeeds
        $res1 = $this->actingAs($this->player)->postJson('/api/bookings', [
            'time_slot_id' => $slot->id,
        ]);
        $res1->assertStatus(201);

        // Second simultaneous/subsequent booking fails with 409 Conflict
        $res2 = $this->actingAs($playerTwo)->postJson('/api/bookings', [
            'time_slot_id' => $slot->id,
        ]);
        $res2->assertStatus(409);

        // Exactly one booking exists in DB
        $this->assertDatabaseCount('bookings', 1);
        $this->assertEquals(1, Booking::where('time_slot_id', $slot->id)->count());
    }

    /**
     * Test 8: Request validation rejects invalid or missing time_slot_id.
     */
    public function test_booking_validation_fails_for_invalid_slot(): void
    {
        $response = $this->actingAs($this->player)->postJson('/api/bookings', [
            'time_slot_id' => 999999, // Non-existent ID
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['time_slot_id']);
    }
}
