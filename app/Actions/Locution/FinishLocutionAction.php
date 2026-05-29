<?php

namespace App\Actions\Locution;

use Illuminate\Support\Facades\DB;

use App\Models\Onair;
use App\Models\Program;
use App\Models\SongRequest;

class FinishLocutionAction
{
    public function execute(): void
    {
        DB::transaction(function () {
            $onair = Onair::live()
                ->first();
            $auto = Program::where('type', 'automatic')
                ->where('is_auto_dj', true)
                ->first();

            if($onair) {
                $onair->update([
                    'in_air' => false,
                    'allows_song_requests' => false,
                ]);

                SongRequest::where('onair_id', $onair->id)
                    ->where('was_reproduced', false)
                    ->where('was_canceled', false)
                    ->update(['was_canceled' => true]);
            }
                    
            if (!empty($auto->phrases) && $auto) {
                $selected = collect($auto->phrases)->random();

                $phrase = [
                    'text' => $selected['text'],
                    'icon' => $selected['icon'],
                    'decoration' => $selected['decoration'],
                ];

                $auto->onair()->create([
                    'type' => 'auto_dj',
                    'phrase' => $phrase,
                ]);
            }
        });
    }
}
