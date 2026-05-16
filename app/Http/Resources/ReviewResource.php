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
            'opinions' => $this->opinionsCurrentWithUser($request),
        ];
    }

    private function opinionsCurrentWithUser(Request $request): array
    {
        $user = $request->user();
        $opinions = OpinionResource::collection($this->opinions)->resolve();

        $userOpinionFound = collect($opinions)->first(
            fn ($opinion) => $opinion['author']['uuid'] === $user->uuid
        );

        if ($userOpinionFound) {
            return [
                $userOpinionFound,
                ...collect($opinions)
                    ->reject(fn ($opinion) => $opinion['author']['uuid'] === $user->uuid)
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
            ...$opinions,
        ];
    }
}
