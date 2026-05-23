<?php

namespace App\Http\Controllers\Concerns;

trait HasFlashMessages
{
    public function flashMessage(string $action)
    {
        $messages = [
            'save' => [
                'icon' => 'ðŸ¥³',
                'message' => 'Salvo, querido! Que feito, hein?',
            ],
            'update' => [
                'icon' => 'ðŸ«¡',
                'message' => 'Atualizado! Ficou maravi..., impecÃ¡vel.',
            ],
            'delete' => [
                'icon' => 'â˜ ï¸',
                'message' => 'Apagado! JÃ¡ tava fazendo hora extra',
            ],
            'deactivate' => [
                'icon' => 'ðŸ˜´',
                'message' => 'Desativado! Bora dormir tambÃ©m.',
            ],
            'activate' => [
                'icon' => 'ðŸ¥±',
                'message' => 'Ativado! Saudades, confesso.',
            ],
            'complete' => [
                'icon' => 'ðŸŽ¯',
                'message' => 'Completado! Finalmente, nÃ©.',
            ],
            'participate' => [
                'icon' => 'ðŸ™‹',
                'message' => 'Participando! Corajoso, vocÃª Ã©!',
            ],
            'start' => [
                'icon' => 'ðŸš€',
                'message' => 'Iniciado! Se nÃ£o explodir...',
            ],
            'finish' => [
                'icon' => 'ðŸŽŠ',
                'message' => 'Finalizado! Nossa, que demora, hein?',
            ],
            'order_fulfilled' => [
                'icon' => 'ðŸŽµ',
                'message' => 'Vamos atender! Que vibe, hein?',
            ],
            'order_canceled' => [
                'icon' => 'ðŸš«',
                'message' => 'Vamos cancelar! Triste, acontece.',
            ],
            'dependencies' => [
                'icon' => 'â›“ï¸',
                'message' => 'Tire os vÃ­nculos antes! Se nÃ£o dÃ¡ ruim...',
            ],
            'error' => [
                'icon' => 'âŒ',
                'message' => 'Algo deu errado!',
            ],
        ];

        $base = $messages[$action] ?? $messages['save'];
        $final = $base['message'];

        return redirect()->back()->with('flash', [
            'id' => uniqid('flash_', true),
            'icon' => $base['icon'],
            'message' => $final,
        ]);
    }
}
