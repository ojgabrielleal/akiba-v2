<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Automatic>
 */
class AutomaticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_default' => false,
            'name' => fake()->word(),
            'image' => '/img/onair/default/program.webp',
            'phrases' => collect([
                [
                    'image' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
                    'phrase' => fake()->sentence(),
                ],
                [
                    'image' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
                    'phrase' => fake()->sentence(),
                ],
                [
                    'image' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
                    'phrase' => fake()->sentence(),
                ],
            ])
        ];
    }
}
