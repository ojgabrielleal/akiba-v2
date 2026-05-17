<?php

namespace Database\Factories;

use Database\Factories\Concerns\HasFakeImages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'image' => $this->fakeImageUrl(),
            'title' => fake()->text(),
            'content' => fake()->paragraph(),
            'cover' => $this->fakeImageUrl(),
            'type' => fake()->randomElement(['published', 'revision', 'draft']),
        ];
    }
}
