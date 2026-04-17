<?php

namespace App\Actions\Administration\User;

use App\Models\User;
use App\Models\Role;

class UpdateUserAccessAction
{
    public function execute(User $user, array $data): User
    {
        if (array_key_exists('roles', $data)) {
            $roles = Role::whereIn('name', $data['roles'])->pluck('id')->toArray();
            $user->roles()->sync($roles);
        }

        if (array_key_exists('password', $data) && !empty($data['password'])) {
            $user->update(['password' => $data['password']]);
        }

        return $user;
    }
}
