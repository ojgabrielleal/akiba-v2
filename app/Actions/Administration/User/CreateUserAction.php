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
        ]);

        $user->roles()->attach($roles);

        return $user;
    }
}
