<?php

namespace Tests\Feature;

use App\Models\Pitch;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeSlotGridTest extends TestCase
{
    use RefreshDatabase;

    private Pitch $pitch;

    protected function setUp(): void
    {
        parent::setUp();

        $owner = User::factory()->owner()->create();
        $this->pitch = Pitch::factory()->create([
            'owner_id' => $owner->id,
            'name' => 'ملعب الأساطير الرياضي',
            'hourly_rate' => 150.00,
        ]);
    }

    public function test_player_can_view_pitch_slots_grid_for_selected_date(): void
    {
        $futureDate = Carbon::tomorrow()->toDateString();

        TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $futureDate,
            'start_time' => '17:30:00',
            'end_time' => '19:00:00',
            'price' => 225.00,
            'status' => 'available',
        ]);

        $response = $this->get(route('pitches.slots', [
            'pitch' => $this->pitch->id,
            'date' => $futureDate,
        ]));

        $response->assertStatus(200);
        $response->assertSee('ملعب الأساطير الرياضي');
        $response->assertSee('225.00');
        $response->assertSee('احجز هذه الفترة');
    }

    public function test_slots_are_properly_filtered_by_date(): void
    {
        $dayOne = Carbon::tomorrow()->toDateString();
        $dayTwo = Carbon::tomorrow()->addDay()->toDateString();

        TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $dayOne,
            'start_time' => '16:00:00',
            'end_time' => '17:30:00',
            'status' => 'available',
        ]);

        TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $dayTwo,
            'start_time' => '20:30:00',
            'end_time' => '22:00:00',
            'status' => 'available',
        ]);

        // Query dayOne slots (04:00 PM)
        $responseOne = $this->get(route('pitches.slots', [
            'pitch' => $this->pitch->id,
            'date' => $dayOne,
        ]));

        $responseOne->assertStatus(200);
        $responseOne->assertSee('04:00');
        $responseOne->assertDontSee('08:30');

        // Query dayTwo slots (08:30 PM)
        $responseTwo = $this->get(route('pitches.slots', [
            'pitch' => $this->pitch->id,
            'date' => $dayTwo,
        ]));

        $responseTwo->assertStatus(200);
        $responseTwo->assertSee('08:30');
        $responseTwo->assertDontSee('04:00');
    }

    public function test_past_date_is_rejected_and_redirects_to_today_per_br01(): void
    {
        $pastDate = Carbon::yesterday()->toDateString();
        $today = Carbon::today()->toDateString();

        $response = $this->get(route('pitches.slots', [
            'pitch' => $this->pitch->id,
            'date' => $pastDate,
        ]));

        $response->assertRedirect(route('pitches.slots', [
            'pitch' => $this->pitch->id,
            'date' => $today,
        ]));
        $response->assertSessionHas('error');
    }

    public function test_api_endpoint_returns_json_matching_contract(): void
    {
        $futureDate = Carbon::tomorrow()->toDateString();

        TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $futureDate,
            'start_time' => '19:00:00',
            'end_time' => '20:30:00',
            'price' => 180.00,
            'status' => 'available',
        ]);

        $response = $this->getJson("/api/pitches/{$this->pitch->id}/slots?date={$futureDate}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'pitch_id',
                'pitch_name',
                'date',
                'slots' => [
                    '*' => [
                        'id',
                        'start_time',
                        'end_time',
                        'price',
                        'status',
                        'is_available',
                        'is_past',
                    ],
                ],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'data' => [
                'pitch_id' => $this->pitch->id,
                'pitch_name' => $this->pitch->name,
                'date' => $futureDate,
            ],
        ]);
    }

    public function test_booked_slot_shows_disabled_booked_badge(): void
    {
        $futureDate = Carbon::tomorrow()->toDateString();

        TimeSlot::factory()->create([
            'pitch_id' => $this->pitch->id,
            'date' => $futureDate,
            'start_time' => '20:30:00',
            'end_time' => '22:00:00',
            'status' => 'booked',
        ]);

        $response = $this->get(route('pitches.slots', [
            'pitch' => $this->pitch->id,
            'date' => $futureDate,
        ]));

        $response->assertStatus(200);
        $response->assertSee('محجوز مسبقاً');
    }
}
