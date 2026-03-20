<?php

namespace App\Http\Resources\Private;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepositoryIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'image' => $this->image, 
            'url' => $this->url, 
            'type' => $this->type,
        ];
    }
}
