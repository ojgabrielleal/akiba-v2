<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;

class DiscordWebhookService
{
    public function sendHookMessage($user, $program)
    {
        if (!app()->environment('production')) {
            return false;
        }

        $webhookUrl = env('DISCORD_STREAM_WEBHOOK');

        if (!$webhookUrl) {
            return false; 
        }

        $genderTitle = $user->gender === 'male' ? 'O DJ' : 'A DJ';

        $payload = [
            'content' => "@everyone @here  
                🎧 {$genderTitle} **{$user->nickname}** está AO VIVO agora com o programa **{$program->name}**!
                👉 Ouça em https://akiba.com.br"
        ];

        Http::post($webhookUrl, $payload);

        return true;
    }
}
