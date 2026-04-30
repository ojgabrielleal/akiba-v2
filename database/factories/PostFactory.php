<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'image' => fake()->imageUrl(),
            'title' => fake()->text(),
            'content' => fake()->paragraph(),
            'cover' => fake()->imageUrl(),
            'type' => fake()->randomElement(['published', 'revision', 'draft']),
        ];
    }
}
