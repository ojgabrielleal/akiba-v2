<?php

namespace App\Actions\Radio;

use App\Models\Music;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class UpdateMusicRankingAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Music $music, ?UploadedFile $imageFile): Music
    {
        $music->update([
            'image_ranking' => $this->image->store('musics/ranking', $imageFile, 'public', $music->image_ranking),
        ]);
        
        return $music;
    }
}
