<?php

namespace App\Http\Resources\Private;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIndexResource extends JsonResource
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
