<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'is_due' => $this->is_due || $this->is_over,
            'dead_line' => $this->dead_line->format('Y-m-d'),
            'dead_line_formatted' => $this->dead_line?->format('d/m'),
            'title' => $this->title,
            'content' => $this->content,
            'responsible' => UserResource::make($this->responsible),
        ];
    }
}
