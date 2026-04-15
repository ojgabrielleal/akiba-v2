<?php

namespace App\Policies;

use App\Models\Automatic;
use App\Models\User;

class AutomaticPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('automatic.list');
    }

    public function view(User $user, Automatic $automatic): bool
    {
        return $user->hasPermission('automatic.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('automatic.create');
    }

    public function update(User $user, Automatic $automatic): bool
    {
        return $user->hasPermission('automatic.update');
    }

    public function delete(User $user, Automatic $automatic): bool
    {
        return $user->hasPermission('automatic.deactivate');
    }
}