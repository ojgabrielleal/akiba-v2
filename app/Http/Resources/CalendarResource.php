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
            'formated_hour' => $this->hour->format('H\hi'),
            'formated_date' => $this->date->format('d/m/Y'),
            'hour' => $this->hour->format('H:i'),
            'date' => $this->date->format('Y-m-d'),
            'content' => $this->content,
            'type' => $this->type,
            'day_of_week' => $this->day_of_week,
            'responsible' => UserResource::make($this->responsible),
            'activity' => $this->has_activity ? ActivityResource::make($this->activity) : null,
        ];
    }
}
