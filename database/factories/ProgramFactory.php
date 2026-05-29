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
            'is_auto_dj' => false,
            'name' => fake()->name(),
            'image' => '/img/locution/program.webp',
            'type' => 'free',
            'phrases' => null,
        ];
    }

    public function withAutomatic(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'automatic',
            'phrases' => [
                [
                    'text' => fake()->sentence(),
                    'icon' => $this->fakeImageUrl(),
                    'decoration' => 'default',
                ],
                [
                    'text' => fake()->sentence(),
                    'icon' => $this->fakeImageUrl(),
                    'decoration' => 'default',
                ],
                [
                    'text' => fake()->sentence(),
                    'icon' => $this->fakeImageUrl(),
                    'decoration' => 'default',
                ],
            ],
        ]);
    }

    public function withFree(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'free',
            'phrases' => null,
            'is_auto_dj' => false,
        ]);
    }

    public function withPrivate(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'private',
            'phrases' => null,
            'is_auto_dj' => false,
        ]);
    }

    public function isAutoDj(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_auto_dj' => true,
        ]);
    }

}
