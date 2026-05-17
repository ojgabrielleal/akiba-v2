<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['post.list', 'post.list.own']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
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
    public function update(User $user, Review $review): bool
    {
        if ($user->hasPermission('post.update')) {
            return true;
        }

        return $user->hasPermission('post.update.own')
            && $review->opinions()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        return $user->hasPermission('post.deactivate');
    }

    /**
     * Determine whether the user can create an opinion for a review.
     */
    public function createOpinion(User $user, Review $review): bool
    {
        return $user->hasPermission('review.opinion.create');
    }

    /**
     * Determine whether the user can update their own opinion for a review.
     */
    public function updateOwnOpinion(User $user, Review $review): bool
    {
        return $user->hasPermission('review.opinion.update.own')
            && $review->opinions()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can approve review opinions.
     */
    public function approveOpinion(User $user, Review $review): bool
    {
        return $user->hasPermission('review.opinion.approve');
    }
}
