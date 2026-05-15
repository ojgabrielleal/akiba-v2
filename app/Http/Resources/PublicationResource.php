<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'publication_type' => $this->publicationType(),
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'title' => $this->title,
            'cover' => $this->cover,
            'views' => $this->views_count,
            'type' => $this->publicationStatus(),
            'author' => UserResource::make($this->author),
        ];
    }

    private function publicationType(): string
    {
        return match (true) {
            $this->resource instanceof Post => 'post',
            $this->resource instanceof Review => 'review',
            $this->resource instanceof Event => 'event',
            default => class_basename($this->resource),
        };
    }

    private function publicationStatus(): ?string
    {
        if ($this->resource instanceof Review) {
            if (! $this->resource->relationLoaded('reviews')) {
                return null;
            }

            $types = $this->reviews
                ->pluck('type')
                ->filter()
                ->unique()
                ->values();

            if ($types->contains('revision')) {
                return 'revision';
            }

            return $types->count() === 1 ? $types->first() : null;
        }

        if ($this->resource instanceof Post || $this->resource instanceof Event) {
            return $this->type;
        }

        return null;
    }
}
