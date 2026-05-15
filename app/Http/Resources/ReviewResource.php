<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'cover' => $this->cover,
            'image' => $this->image,
            'title' => $this->title,
            'year_of_release' => $this->year_of_release,
            'sinopse' => $this->sinopse,
            'views' => $this->views_count,
            'reviews' => $this->reviewsCurrentWithUser($request),
        ];
    }

    private function reviewsCurrentWithUser(Request $request): array
    {
        $user = $request->user();
        $reviews = ReviewContentResource::collection($this->reviews)->resolve();

        $userReviewFound = collect($reviews)->first(
            fn ($review) => $review['author']['uuid'] === $user->uuid
        );

        if ($userReviewFound) {
            return [
                $userReviewFound,
                ...collect($reviews)
                    ->reject(fn ($review) => $review['author']['uuid'] === $user->uuid)
                    ->values()
                    ->all(),
            ];
        }

        return [
            [
                'uuid' => null,
                'content' => 'Escreva o seu primeiro review',
                'author' => [
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'nickname' => $user->nickname,
                    'avatar' => $user->avatar,
                ],
            ],
            ...$reviews,
        ];
    }
}
