<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Administrador padrão para acesso
        User::factory()
            ->has(UserPreference::factory(), 'preferences')
            ->has(UserSocial::factory(), 'socials')
            ->hasAttached(Role::where('name', 'administrator')->first(), [], 'roles')
            ->create([
                'username' => 'admin',
                'password' => 'admin',
                'name' => 'Yagami Kou',
                'nickname' => 'Yagami',
                'gender' => 'female',
            ]);

        // Outros administradores gerados aleatoriamente
        User::factory(3)
            ->has(UserPreference::factory(), 'preferences')
            ->has(UserSocial::factory(), 'socials')
            ->hasAttached(Role::where('name', 'administrator')->first(), [], 'roles')
            ->create();

        // Vários outros usuários com papéis aleatórios ou normais
        $roles = Role::where('name', '!=', 'administrator')->get();
        if ($roles->count() > 0) {
            foreach ($roles as $role) {
                User::factory(10)
                    ->has(UserPreference::factory(), 'preferences')
                    ->has(UserSocial::factory(), 'socials')
                    ->hasAttached($role, [], 'roles')
                    ->create();
            }
        } else {
            User::factory(20)
                ->has(UserPreference::factory(), 'preferences')
                ->has(UserSocial::factory(), 'socials')
                ->create();
        }
    }
}
