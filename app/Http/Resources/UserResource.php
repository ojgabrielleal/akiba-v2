<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private ?string $format = null;

    public function format(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->format === 'compact') {
            return [
                'uuid' => $this->uuid,
                'name' => $this->name,
                'nickname' => $this->nickname,
                'avatar' => $this->avatar,
            ];
        }

        return [
            'uuid' => $this->uuid,
            'is_virtual' => $this->is_virtual,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'birthday' => $this->birthday?->format('Y-m-d'),
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'bibliography' => $this->bibliography,
            'favorites' => UserFavoriteResource::collection($this->favorites),
            'socials' => UserSocialResource::collection($this->socials),
            'preferences' => [
                'likes' => UserPreferenceResource::collection($this->preferences->filter(function ($item) {
                    return $item->is_like;
                })
                ->values()),

                'unlikes' => UserPreferenceResource::collection($this->preferences->filter(function ($item) {
                    return !$item->is_like;
                })
                ->values()),
            ],
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
