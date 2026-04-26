<?php

namespace App\Actions\Locution;

use App\Models\Onair;
use App\Models\Program;
use App\Models\SongRequest;

class FinishLocutionAction
{
    public function execute(): void
    {
        $onair = Onair::live()->first();

        if ($onair) {
            $onair->update([
                'in_air' => false,
                'allows_song_requests' => false,
            ]);
        }

        $auto = Program::where('type', 'automatic')
            ->where('is_default', true)
            ->first();

        if ($auto) {
            $selected = collect($auto->phrases)->random();

            $auto->onair()->create([
                'type' => 'automatic',
                'phrase' => $selected,
                'icon' => $selected['icon'] ?? null,
            ]);
        }

        if ($onair) {
            SongRequest::where('onair_id', $onair->id)
                ->where('was_reproduced', false)
                ->where('was_canceled', false)
                ->update([
                    'was_canceled' => true,
                ]);
        }
    }
}
