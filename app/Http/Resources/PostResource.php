<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'type' => $this->type,
            'title' => $this->title,
            'image' => $this->image,
            'cover' => $this->cover,
            'content' => $this->content,
            'author' => UserResource::make($this->author),
            'references' => ReferenceResource::collection($this->references),
            'reactions' => ReactionResource::collection($this->reactions),
            'tags' => TagResource::collection($this->tags),
            'views' => $this->views_count,
        ];
    }
}
