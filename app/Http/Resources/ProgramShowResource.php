<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramShowResource extends JsonResource
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
            'image' => $this->image,
            'type' => $this->type,
            'host' => [
                'uuid' => $this->host->uuid,
                'name' => $this->host->name,
                'nickname' => $this->host->nickname,
                'avatar' => $this->host->avatar,
                'gender' => $this->host->gender
            ],
            'schedules' => $this->schedules->map(fn($item) => [
                'hour' => $item->hour,
                'day' => $item->day
            ])
        ];
    }
}
