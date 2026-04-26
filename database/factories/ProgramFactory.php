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
            'image' => '/img/locution/default/program.webp',
            'type' => 'free',
            'phrases' => null,
        ];
    }

    public function automatic(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'automatic',
            'phrases' => [
                [
                    'text' => fake()->sentence(),
                    'icon' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
                    'decoration' => 'default',
                ],
                [
                    'text' => fake()->sentence(),
                    'icon' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
                    'decoration' => 'default',
                ],
                [
                    'text' => fake()->sentence(),
                    'icon' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
                    'decoration' => 'default',
                ],
            ],
        ]);
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'free',
            'phrases' => null,
            'is_default' => false,
        ]);
    }

    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'private',
            'phrases' => null,
            'is_default' => false,
        ]);
    }
}
