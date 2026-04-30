<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['OP', 'ED']),
            'production' => fake()->word(),
            'image' => fake()->imageUrl(),
            'artist' => fake()->name(),
            'name' => fake()->name(),
            'in_ranking' => fake()->boolean(),
            'image_ranking' => fake()->imageUrl(),
            'song_requests_total' => fake()->randomDigit(),
        ];
    }
}
