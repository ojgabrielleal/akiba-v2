<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResourceCollection extends ResourceCollection
{
    private ?string $format = null;

    public function format(?string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function toArray(Request $request): array
    {
        return $this->collection
            ->map(fn (PostResource $post) => $post->format($this->format)->resolve($request))
            ->all();
    }
}
