<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'has_activity' => $this->has_activity,
            'title' => $this->title,
            'hour' => $this->hour->format('H:m'),
            'date' => $this->date->format('d/m/Y'),
            'content' => $this->content,
            'type' => $this->type,
            'day_of_week' => $this->day_of_week,
            'responsible' => [
                'uuid' => $this->responsible->uuid,
                'name' => $this->responsible->name,
                'nickname' => $this->responsible->nickname,
                'avatar' => $this->responsible->avatar,
                'gender' => $this->responsible->gender
            ],
            'activity' => $this->has_activity ? [
                'uuid' => $this->activity->uuid,
                'title' => $this->activity->title,
            ] : null,
        ];
    }
}
