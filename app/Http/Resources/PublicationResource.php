<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'title' => $this->title,
            'cover' => $this->cover,
            'views' => $this->views_count,
            'type' => $this->type(),
            'author' => UserResource::make($this->author),
        ];
    }

    private function type(): string
    {
        if($this->review && $this->review->opinions->contains('type', 'revision')){
            return 'revision';
        }

        return $this->type;
    }
}
