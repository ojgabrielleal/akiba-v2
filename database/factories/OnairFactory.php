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
                'decoration' => null,
                 'texture' => null,
            ],
            'type' => fake()->randomElement(['auto_dj', 'live', 'scheduled', 'playlist']),
            'start_at' => null,
            'finish_at' => null,
            'allows_song_requests' => true,
            'song_requests_total' => fake()->randomNumber(),
        ];
    }

    public function withAutoDj(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'auto_dj',
        ]);
    }

    public function autoDj(): static
    {
        return $this->withAutoDj();
    }

    public function playlist(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'playlist',
        ]);
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
