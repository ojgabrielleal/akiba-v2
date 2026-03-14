<?php

namespace App\Http\Resources\Private;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'allows_confirmations' => $this->allows_confirmations,
            'title' => $this->title,
            'content' => $this->content,
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
