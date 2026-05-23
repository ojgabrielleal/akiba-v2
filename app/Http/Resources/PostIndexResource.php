<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'title' => $this->title,
            'cover' => $this->cover,
            'views' => $this->views_count,
            'status' => $this->status(),
            'module' => $this->type(),
            'author' => UserResource::make($this->author),
        ];
    }

    public function type(): string 
    {
        if($this->review){
            return 'review';
        }

        if($this->event){
            return 'event';
        }

        return 'post';
    }

    private function status(): string
    {
        if($this->review && $this->review->opinions->contains('status', 'revision')){
            return 'revision';
        }

        return $this->status;
    }
}
