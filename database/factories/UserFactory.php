<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserPreference;
use App\Models\UserSocial;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'is_bot' => fake()->boolean(),
            'slug' => fake()->slug(),
            'username' => fake()->userName(),
            'password' => fake()->password(),
            'name' => fake()->name(),
            'nickname' => fake()->userName(),
            'gender' => $gender,
            'avatar' => fake()->imageUrl(),
            'birthday' => fake()->date(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'bibliography' => fake()->paragraph(),
        ];
    }

    public function administrator(): static
    {
        return $this
            ->state(fn (array $attributes) => [
                'username' => 'admin',
                'password' => 'admin',
                'name' => 'Yagami Kou',
                'nickname' => 'Yagami',
                'gender' => 'female',
            ])
            ->afterCreating(function (User $user) {
                $administrator = Role::where('name', 'administrator')->first();

                if ($administrator) {
                    $user->roles()->syncWithoutDetaching([$administrator->id]);
                }
            });
    }

    public function withRole(): static
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::where('name', '!=', 'administrator')
                ->inRandomOrder()
                ->first();

            if ($role) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        });
    }

    public function withDefaults(): static
    {
        return $this->afterCreating(function (User $user) {
            if (!$user->socials()->exists()) {
                foreach ($this->socials() as $social) {
                    $user->socials()->save(UserSocial::factory()->make($social));
                }
            }

            if (!$user->preferences()->exists()) {
                foreach ($this->preferences() as $preference) {
                    $user->preferences()->save(UserPreference::factory()->make($preference));
                }
            }

            if (!$user->favorites()->exists()) {
                foreach ($this->favorites() as $favorite) {
                    $user->favorites()->save(UserFavorite::factory()->make($favorite));
                }
            }
        });
    }

    private function socials(): array
    {
        return [
            ['name' => 'Facebook', 'url' => null],
            ['name' => 'Instagram', 'url' => null],
            ['name' => 'Twitter', 'url' => null],
            ['name' => 'Bluesky', 'url' => null],
            ['name' => 'Discord', 'url' => null],
            ['name' => 'YouTube', 'url' => null],
            ['name' => 'MyAnimeList', 'url' => null],
        ];
    }

    private function preferences(): array
    {
        return [
            ['is_like' => true, 'content' => '#'],
            ['is_like' => true, 'content' => '#'],
            ['is_like' => true, 'content' => '#'],
            ['is_like' => false, 'content' => '#'],
            ['is_like' => false, 'content' => '#'],
            ['is_like' => false, 'content' => '#'],
        ];
    }

    private function favorites(): array
    {
        return [
            ['name' => null, 'image' => null],
            ['name' => null, 'image' => null],
            ['name' => null, 'image' => null],
        ];
    }
}
