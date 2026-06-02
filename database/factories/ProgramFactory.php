<?php

namespace Database\Factories;

use Database\Factories\Concerns\HasFakeImages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
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
            'is_active' => true,
            'name' => fake()->name(),
            'image' => '/img/locution/program.webp',
            'access_type' => 'free',
            'execution_mode' => 'live',
            'phrases' => $this->phrases(),
        ];
    }

    public function withPlaylist(): static
    {
        return $this->state(fn (array $attributes) => [
            'access_type' => 'free',
            'execution_mode' => 'playlist',
            'phrases' => $this->phrases(),
        ]);
    }

    public function withFree(): static
    {
        return $this->state(fn (array $attributes) => [
            'access_type' => 'free',
            'execution_mode' => 'live',
            'phrases' => $this->phrases(),
        ]);
    }

    public function withPrivate(): static
    {
        return $this->state(fn (array $attributes) => [
            'access_type' => 'private',
            'execution_mode' => 'live',
            'phrases' => $this->phrases(),
        ]);
    }

    public function withScheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'execution_mode' => 'scheduled',
        ]);
    }

    public function withLive(): static
    {
        return $this->state(fn (array $attributes) => [
            'execution_mode' => 'live',
        ]);
    }

    private function phrases(): array
    {
        return [
            [
                'text' => fake()->sentence(),
                'icon' => $this->fakeImageUrl(),
                'decoration' => 'default',
                'texture' => null,
            ],
            [
                'text' => fake()->sentence(),
                'icon' => $this->fakeImageUrl(),
                'decoration' => 'default',
                'texture' => null,
            ],
            [
                'text' => fake()->sentence(),
                'icon' => $this->fakeImageUrl(),
                'decoration' => 'default',
                'texture' => null,
            ],
        ];
    }
}
