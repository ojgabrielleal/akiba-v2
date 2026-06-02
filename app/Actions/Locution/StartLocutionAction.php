<?php

namespace App\Actions\Locution;

use Illuminate\Support\Facades\DB;
use App\Services\External\DiscordWebhookService;

use App\Models\Onair;
use App\Models\Program;
use App\Models\User;

class StartLocutionAction
{
    private DiscordWebhookService $discord;

    public function __construct(DiscordWebhookService $discord)
    {
        $this->discord = $discord;
    }

    public function execute(User $user, Program $program, array $data): void
    {
        DB::transaction(function () use ($user, $program, $data) {
            Onair::live()->first()->update([
                'in_air' => false,
            ]);

            if($program->access_type === 'free') {
                $program->update([
                    'user_id' => $user->id,
                ]);
            }

            $program->onair()->create([
                'execution_mode' => 'live',
                'phrase' => [
                    'text' => $data['phrase']['text'],
                    'icon' => $data['phrase']['icon'],
                    'decoration' => $data['phrase']['decoration'],
                    'texture' => $data['phrase']['texture'],
                ],
                'allows_song_requests' => true,
            ]);
        });

        $this->discord->sendHookMessage($user, $program);
    }
}
