<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Onair>
 */
class OnairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'in_air' => true,
            'phrase' => [
                'text' => fake()->sentence(),
                'icon' => fake()->imageUrl(),
                'decoration' => 'default',
            ],
            'type' => fake()->randomElement(['automatic', 'live', 'scheduled']),
            'icon' => fake()->imageUrl(),
            'allows_song_requests' => true,
            'song_requests_total' => fake()->randomNumber(),
        ];
    }
}
