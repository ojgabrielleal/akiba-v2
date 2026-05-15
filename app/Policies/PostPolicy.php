<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['publication.list', 'publication.list.own']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermission('publication.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('publication.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasPermission('publication.update')) {
            return true;
        }

        return $user->hasPermission('publication.update.own') && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model (deactivate).
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermission('publication.deactivate');
    }
}
