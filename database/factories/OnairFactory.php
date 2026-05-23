<?php

namespace Database\Factories;

use Database\Factories\Concerns\HasFakeImages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Onair>
 */
class OnairFactory extends Factory
{
    use HasFakeImages;

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
                'icon' => $this->fakeImageUrl(),
                'decoration' => 'default',
            ],
            'type' => fake()->randomElement(['automatic', 'live', 'scheduled']),
            'icon' => $this->fakeImageUrl(),
            'allows_song_requests' => true,
            'song_requests_total' => fake()->randomNumber(),
        ];
    }

    public function withAutomatic(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'automatic',
        ]);
    }

    public function automatic(): static
    {
        return $this->withAutomatic();
    }

    public function live(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'live',
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'scheduled',
        ]);
    }
}
