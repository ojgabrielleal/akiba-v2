<?php

namespace App\Actions\Radio;

use App\Models\Music;

class GenerateMusicRankingAction
{
    public function execute(): void
    {
        Music::ranking()->update(['in_ranking' => false]);
        $musicList = Music::orderBy('song_requests_total', 'desc')->limit(10)->get();

        $musicList->each(function ($music) {
            $music->update(['in_ranking' => true]);
        });
    }
}
