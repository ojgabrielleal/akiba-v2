<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cover' => fake()->imageUrl(),
            'image' => fake()->imageUrl(),
            'title' => fake()->word(),
            'type' => fake()->randomElement(['published', 'revision', 'draft']),
            'content' => fake()->paragraph(),
            'dates' => fake()->date(),
            'address' => fake()->address(),
        ];
    }
}
