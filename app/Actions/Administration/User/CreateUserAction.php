<?php

namespace App\Actions\Administration\User;

use App\Models\User;
use App\Models\Role;

class CreateUserAction
{
    public function execute(array $data): User
    {
        $roles = Role::whereIn('name', $data['roles'] ?? [])->pluck('id');
        $avatar = ($data['gender'] ?? '') === 'male'
            ? '/img/users/avatarMale.webp'
            : '/img/users/avatarFemale.webp';

        $user = User::create([
            'username' => $data['username'] ?? null,
            'password' => $data['password'] ?? null,
            'name' => $data['name'] ?? null,
            'avatar' => $avatar,
            'nickname' => $data['nickname'] ?? null,
            'gender' => $data['gender'] ?? null,
            'is_bot' => $data['is_bot'] ?? false,
        ]);

        $socials = [
            ['name' => 'Twitter', 'url' => null],
            ['name' => 'Facebook', 'url' => null],
            ['name' => 'Instagram', 'url' => null],
            ['name' => 'Youtube', 'url' => null],
            ['name' => 'Discord', 'url' => null],
            ['name' => 'MyAnimeList', 'url' => null],
        ];

        $user->roles()->attach($roles);
        $user->socials()->createMany($socials);

        return $user;
    }
}
