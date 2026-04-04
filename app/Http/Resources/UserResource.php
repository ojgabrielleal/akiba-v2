<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'birthday' => $this->birthday?->format('Y-m-d'),
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'bibliography' => $this->bibliography,
            'socials' => $this->socials->map(fn($item) => [
                    'uuid' => $item->uuid,
                    'name' => $item->name,
                    'url' => $item->url,
            ]),
            'preferences' => [
                'likes' => $this->preferences->filter(function ($item) {
                    return $item->is_like;
                })
                ->values()
                ->map(fn($item) => [
                    'uuid' => $item->uuid,
                    'content' => $item->content
                ]),

                'unlikes' => $this->preferences->filter(function ($item) {
                    return !$item->is_like;
                })
                ->values()
                ->map(fn($item) => [
                    'uuid' => $item->uuid,
                    'content' => $item->content
                ]),
            ],
            'roles' => $this->roles->map(fn($item)=>[
                'uuid' => $item->uuid,
                'label' => $item->label,
                'name' => $item->name,
                'weight' => $item->weight,
                'description' => $item->description,
            ])
        ];
    }
}
