<?php

namespace App\Actions\Publication;

use App\Models\Event;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class IndexPublicationAction
{
    public function execute(User $user): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $limit = 10;

        $publications = $this->publications($user, $limit)
            ->values();

        return new LengthAwarePaginator(
            $publications->forPage($page, $limit)->values(),
            $publications->count(),
            $limit,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }

    private function publications(User $user, int $limit): Collection
    {
        return $this->posts($user, $limit)
            ->concat($this->events($user, $limit))
            ->concat($this->reviews($limit));
    }

    private function posts(User $user, int $limit): Collection
    {
        $query = Post::active()
            ->with('author')
            ->featured()
            ->latest();

        if (!$user->hasPermission('publication.list.own')) {
            $query->active()->mine()->featured()->latest();
        }

        return $query->take($limit)->get();
    }

    private function events(User $user, int $limit): Collection
    {
        $query = Event::active()
            ->with(['author'])
            ->featured()
            ->latest();

        if (!$user->hasPermission('publication.list.own')) {
            $query->active()->mine()->featured()->latest();
        }

        return $query->take($limit)->get();
    }

    private function reviews(int $limit): Collection
    {
        $query = Review::active()
            ->with('opinions.author')
            ->featured()
            ->latest();

        return $query->take($limit)->get();
    }
}
