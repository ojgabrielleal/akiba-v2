<?php

namespace App\Actions\Publication;

use App\Models\Event;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class DeactivatePublicationAction
{
    public function execute(string $model, string $uuid): void
    {
        $publication = $this->publication($model, $uuid);

        $publication->update([
            'is_active' => false,
        ]);
    }

    private function publication(string $model, string $uuid): Model
    {
        return match ($model) {
            'post' => Post::where('uuid', $uuid)->firstOrFail(),
            'event' => Event::where('uuid', $uuid)->firstOrFail(),
            'review' => Review::where('uuid', $uuid)->firstOrFail(),
            default => throw new InvalidArgumentException('Invalid publication type.'),
        };
    }
}
