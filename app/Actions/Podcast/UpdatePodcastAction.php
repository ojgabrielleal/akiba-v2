<?php

namespace App\Actions\Podcast;

use App\Models\Podcast;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdatePodcastAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Podcast $podcast, array $data, ?UploadedFile $imageFile): Podcast
    {
        return DB::transaction(function () use ($podcast, $data, $imageFile) {
            $podcast->fill([
                'image' => $this->image->store('podcasts', $imageFile, 'public', $podcast->image),
                'season' => array_key_exists('season', $data) ? $data['season'] : $podcast->season,
                'episode' => array_key_exists('episode', $data) ? $data['episode'] : $podcast->episode,
                'title' => array_key_exists('title', $data) ? $data['title'] : $podcast->title,
                'summary' => array_key_exists('summary', $data) ? $data['summary'] : $podcast->summary,
                'description' => array_key_exists('description', $data) ? $data['description'] : $podcast->description,
                'audio' => array_key_exists('audio', $data) ? $data['audio'] : $podcast->audio,
            ]);

            if ($podcast->isDirty()) {
                $podcast->save();
            }

            return $podcast;
        });
    }
}
