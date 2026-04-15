<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutomaticResource extends JsonResource
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
            'is_default' => $this->is_default,
            'name' => $this->name,
            'image' => $this->image,
            'phrases' => $this->phrases,
            'host' => [
                'uuid' => $this->host->uuid,
                'name' => $this->host->name,
                'nickname' => $this->host->nickname,
                'avatar' => $this->host->avatar,
                'gender' => $this->host->gender
            ],
        ];
    }
}
