<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_reference' => 'BK-' . strtoupper(Str::random(8)),
            'user_id' => User::factory()->player(),
            'time_slot_id' => TimeSlot::factory(),
            'total_price' => fake()->randomElement([100.00, 150.00, 200.00]),
            'status' => 'confirmed',
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
