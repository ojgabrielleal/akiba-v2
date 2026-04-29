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
            'references' => PostReferenceResource::collection($this->references),
            'reactions' => PostReactionResource::collection($this->reactions),
            'categories' => PostCategoryResource::collection($this->categories),
            'views' => $this->views_count,
        ];
    }
}
