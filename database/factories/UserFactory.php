<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->attributes['gender'] ?? fake()->randomElement(['male', 'female']);

        return [
            'is_active' => true,
            'is_auto' => fake()->boolean(),
            'slug' => fake()->slug(),
            'username' => fake()->userName(),
            'password' => Hash::make(fake()->password()),
            'name' => fake()->name(),
            'nickname' => fake()->userName(),
            'gender' => $gender,
            'avatar' => $gender === 'male' ? '/img/users/avatarMale.webp' : '/img/users/avatarFemale.webp',
            'birthday' => fake()->date(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'bibliography' => fake()->paragraph(),
        ];
    }
}
