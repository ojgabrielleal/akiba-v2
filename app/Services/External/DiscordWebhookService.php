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
        // A imagem do banco já vem com o prefixo '/storage/' pelo ImageProcessService
        $avatarUrl = $user->avatar ? asset($user->avatar) : asset('assets/default-avatar.png');

        $payload = [
            'content' => "@everyone @here Olá otakus amados!\n\n🔴 **PROGRAMA AO VIVO rolando agora!**",
            'embeds' => [
                [
                    'title' => "{$program->name} NO AR!",
                    'description' => "🎧 {$genderTitle} **{$user->nickname}** sentou no estúdio e já está no ar!\n\nOuça agora na Akiba.\n👉 **[Clique aqui para sintonizar na Akiba!](https://akiba.com.br)**",
                    'color' => hexdec("FF6B00"), // Laranja vibrante estilo Akiba
                    'author' => [
                        'name' => "DJ {$user->nickname}",
                    ],
                    'timestamp' => now()->toIso8601String()
                ]
            ]
        ];

        Http::post($webhookUrl, $payload);

        return true;
    }
}
