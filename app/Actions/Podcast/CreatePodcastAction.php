<?php

namespace App\Actions\Podcast;

use App\Models\Podcast;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class CreatePodcastAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(string $userId, array $data, ?UploadedFile $imageFile): Podcast
    {
        return Podcast::create([
            'user_id' => $userId,
            'image' => $this->image->store('podcasts', $imageFile),
            'season' => $data['season'] ?? null,
            'episode' => $data['episode'] ?? null,
            'title' => $data['title'] ?? null,
            'summary' => $data['summary'] ?? null,
            'description' => $data['description'] ?? null,
            'audio' => $data['audio'] ?? null,
        ]);
    }
}
