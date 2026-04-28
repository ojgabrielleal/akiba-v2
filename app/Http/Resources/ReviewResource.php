<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'cover' => $this->cover,
            'image' => $this->image,
            'title' => $this->title,
            'sinopse' => $this->sinopse,
            'views' => $this->views_count,
            'reviews' => ReviewContentResource::collection($this->reviews),
        ];
    }
}
