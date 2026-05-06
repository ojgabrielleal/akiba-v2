<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_active' => true,
            'is_default' => false,
            'name' => fake()->name(),
            'image' => fake()->imageUrl(),
            'type' => 'free',
            'phrases' => null,
        ];
    }

    public function isDefault(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
        ]);
    }

    public function withAutomatic(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'automatic',
            'phrases' => [
                [
                    'text' => fake()->sentence(),
                    'icon' => fake()->imageUrl(),
                    'decoration' => 'default',
                ],
                [
                    'text' => fake()->sentence(),
                    'icon' => fake()->imageUrl(),
                    'decoration' => 'default',
                ],
                [
                    'text' => fake()->sentence(),
                    'icon' => fake()->imageUrl(),
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
            'is_default' => false,
        ]);
    }

    public function withPrivate(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'private',
            'phrases' => null,
            'is_default' => false,
        ]);
    }
}
