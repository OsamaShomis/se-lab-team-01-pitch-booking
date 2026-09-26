<?php

namespace Database\Factories;

use App\Models\Pitch;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startHour = fake()->numberBetween(16, 22);
        $startTime = sprintf('%02d:00:00', $startHour);
        $endTime = sprintf('%02d:00:00', $startHour + 1);

        return [
            'pitch_id' => Pitch::factory(),
            'date' => fake()->dateTimeBetween('now', '+14 days')->format('Y-m-d'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => fake()->randomElement([100.00, 150.00, 200.00]),
            'status' => 'available',
        ];
    }
}
