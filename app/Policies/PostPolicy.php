<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermission('post.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('post.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasPermission('post.update')) {
            return true;
        }

        return $user->hasPermission('post.update.own') && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model (deactivate).
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermission('post.deactivate');
    }
}
