<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        $socials = [
            ['name' => 'Facebook', 'url' => null],
            ['name' => 'Instagram', 'url' => null],
            ['name' => 'Twitter', 'url' => null],
            ['name' => 'Bluesky', 'url' => null],
            ['name' => 'Discord', 'url' => null],
            ['name' => 'YouTube', 'url' => null],
        ];

        $preferences = [
            ['is_like' => true, 'content' => '#'],
            ['is_like' => true, 'content' => '#'],
            ['is_like' => true, 'content' => '#'],
            ['is_like' => false, 'content' => '#'],
            ['is_like' => false, 'content' => '#'],
            ['is_like' => false, 'content' => '#'],
        ];

        User::factory()
            ->hasAttached(Role::where('name', 'administrator')->first(), [], 'roles')
            ->afterCreating(function ($user) use ($socials, $preferences) {
                foreach ($socials as $social) {
                    $user->socials()->save(UserSocial::factory()->make($social));
                }
                foreach ($preferences as $preference){
                    $user->preferences()->save(UserPreference::factory()->make($preference));
                }
            })
            ->create([
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'name' => 'Yagami Kou',
                'nickname' => 'Yagami',
                'gender' => 'female',
            ]);

        $roles = Role::where('name', '!=', 'administrator')->get();
        User::factory(5)
            ->afterCreating(function ($user) use ($roles, $socials, $preferences) {
                $user->roles()->attach($roles->random()->id);
                foreach ($socials as $social) {
                    $user->socials()->save(UserSocial::factory()->make($social));
                }
                foreach ($preferences as $preference){
                    $user->preferences()->save(UserPreference::factory()->make($preference));
                }
            })
            ->create();
    }
}