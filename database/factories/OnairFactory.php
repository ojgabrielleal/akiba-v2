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
        $type = fake()->randomElement(['auto_dj', 'live', 'scheduled', 'playlist']);
        $startsAt = now()->subMinutes(fake()->numberBetween(5, 30));

        return [
            'in_air' => true,
            'phrase' => [
                'text' => fake()->sentence(),
                'icon' => $this->fakeImageUrl(),
                'decoration' => null,
                 'texture' => null,
            ],
            'type' => $type,
            'start_at' => in_array($type, ['scheduled', 'playlist']) ? $startsAt : null,
            'finish_at' => in_array($type, ['scheduled', 'playlist'])
                ? $startsAt->copy()->addMinutes(fake()->numberBetween(60, 180))
                : null,
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
        $startsAt = now()->subMinutes(fake()->numberBetween(5, 30));

        return $this->state(fn (array $attributes) => [
            'type' => 'playlist',
            'start_at' => $startsAt,
            'finish_at' => $startsAt->copy()->addMinutes(fake()->numberBetween(60, 180)),
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
        $startsAt = now()->subMinutes(fake()->numberBetween(5, 30));

        return $this->state(fn (array $attributes) => [
            'type' => 'scheduled',
            'start_at' => $startsAt,
            'finish_at' => $startsAt->copy()->addMinutes(fake()->numberBetween(60, 180)),
        ]);
    }
}
