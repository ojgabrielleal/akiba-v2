<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostListAction
{
    public function execute(User $user): LengthAwarePaginator
    {
        $query = Post::active()
            ->featured()
            ->with(['author', 'review.opinions'])
            ->orderBy('created_at','desc');

        if ($user->hasPermission('post.list')) {
            return $query->paginate(10);
        }

        if ($user->hasPermission('post.list.own')) {
            $query->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('review.opinions', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        return $query->paginate(10);
    }
}
