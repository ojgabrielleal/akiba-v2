<?php

namespace App\Actions\Podcast;

use App\Models\Podcast;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class UpdatePodcastAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Podcast $podcast, array $data, ?UploadedFile $imageFile): Podcast
    {
        $podcast->fill([
            'image' => $this->image->store('podcasts', $imageFile, 'public', $podcast->image),
            'season' => $data['season'] ?? $podcast->season,
            'episode' => $data['episode'] ?? $podcast->episode,
            'title' => $data['title'] ?? $podcast->title,
            'summary' => $data['summary'] ?? $podcast->summary,
            'description' => $data['description'] ?? $podcast->description,
            'audio' => $data['audio'] ?? $podcast->audio,
        ]);

        if ($podcast->isDirty()) {
            $podcast->save();
        }

        return $podcast;
    }
}
