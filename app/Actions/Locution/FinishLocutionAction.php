<?php

namespace App\Actions\Locution;

use App\Models\Onair;
use App\Models\Program;
use App\Models\SongRequest;
use Illuminate\Support\Facades\DB;

class FinishLocutionAction
{
    public function execute(): void
    {
        DB::transaction(function () {
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

            if ($auto && ! empty($auto->phrases)) {
                $selected = collect($auto->phrases)->random();

                $phrase = [
                    'text' => $selected['text'] ?? null,
                    'icon' => $selected['icon'] ?? null,
                    'decoration' => $selected['decoration'] ?? null,
                ];

                $auto->onair()->create([
                    'type' => 'automatic',
                    'phrase' => $phrase,
                    'icon' => $phrase['icon'],
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
        });
    }
}
