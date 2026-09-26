<?php

namespace Database\Factories;

use App\Models\Pitch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pitch>
 */
class PitchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory()->owner(),
            'name' => fake()->company() . ' Stadium',
            'location' => fake()->city() . ', ' . fake()->streetAddress(),
            'turf_type' => fake()->randomElement(['artificial', 'natural', 'hybrid']),
            'hourly_rate' => fake()->randomElement([100.00, 150.00, 200.00, 250.00]),
            'contact_phone' => fake()->numerify('05########'),
            'image_url' => null,
            'description' => fake()->paragraph(),
            'is_active' => true,
        ];
    }
}
