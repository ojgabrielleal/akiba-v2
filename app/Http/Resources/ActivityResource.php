<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'allows_confirmations' => $this->allows_confirmations,
            'content' => $this->content,
            'limit' => $this->limit->format('Y-m-d'),
            'hour' => $this->calendar?->hour->format('H:i'),
            'date' => $this->calendar?->date->format('Y-m-d'),
            'author' => [
                'uuid' => $this->author->uuid,
                'name' => $this->author->name,
                'nickname' => $this->author->nickname,
                'avatar' => $this->author->avatar,
                'gender' => $this->author->gender

            ],
            'confirmations' => $this->confirmations->map(fn($item) => [
                'uuid' => $item->uuid,
                'name' => $item->name,
                'nickname' => $item->nickname,
                'avatar' => $item->avatar,
            ]),
        ];
    }
}
