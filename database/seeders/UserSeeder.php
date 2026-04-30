<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserPreference;
use App\Models\UserSocial;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socials = $this->socials();
        $preferences = $this->preferences();
        $favorites = $this->favorites();

        $this->seedAdministration($socials, $preferences, $favorites);
        $this->seedNonAdministrationContent($socials, $preferences, $favorites);
    }

    private function seedAdministration(array $socials, array $preferences, array $favorites): void
    {
        User::factory()
            ->hasAttached(Role::where('name', 'administrator')->first(), [], 'roles')
            ->afterCreating(function ($user) use ($socials, $preferences, $favorites) {
                foreach ($socials as $social) {
                    $user->socials()->save(UserSocial::factory()->make($social));
                }
                foreach ($preferences as $preference){
                    $user->preferences()->save(UserPreference::factory()->make($preference));
                }
                foreach ($favorites as $favorite){
                    $user->favorites()->save(UserFavorite::factory()->make($favorite));
                }
            })
            ->create([
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'name' => 'Yagami Kou',
                'nickname' => 'Yagami',
                'gender' => 'female',
            ]);
    }

    private function seedNonAdministrationContent(array $socials, array $preferences, array $favorites): void
    {
        $roles = Role::where('name', '!=', 'administrator')->get();
        User::factory(5)
            ->afterCreating(function ($user) use ($roles, $socials, $preferences, $favorites) {
                $user->roles()->attach($roles->random()->id);
                foreach ($socials as $social) {
                    $user->socials()->save(UserSocial::factory()->make($social));
                }
                foreach ($preferences as $preference){
                    $user->preferences()->save(UserPreference::factory()->make($preference));
                }
                foreach ($favorites as $favorite){
                    $user->favorites()->save(UserFavorite::factory()->make($favorite));
                }
            })
            ->create();
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
