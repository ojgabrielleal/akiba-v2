<?php

namespace App\Traits;

trait HasFlashMessages  
{
    public function flashMessage(string $action)
    {
        $messages = [
            'save' => [
                'icon' => '🥳',
                'message' => 'Salvo, querido! Que feito, hein?'
            ],
            'update' => [
                'icon' => '🫡',
                'message' => 'Atualizado! Ficou maravi..., impecável.'
            ],
            'delete' => [
                'icon' => '☠️',
                'message' => 'Apagado! Já tava fazendo hora extra'
            ],
            'deactivate' => [
                'icon' => '😴',
                'message' => 'Desativado! Bora dormir também.'
            ],
            'activate' => [
                'icon' => '🥱',
                'message' => 'Ativado! Saudades, confesso.'
            ],
            'complete' => [
                'icon' => '🎯',
                'message' => 'Completado! Finalmente, né.'
            ],
            'participate' => [
                'icon' => '🙋',
                'message' => 'Participando! Corajoso, você é!'
            ],
            'start' => [
                'icon' => '🚀',
                'message' => 'Iniciado! Se não explodir...'
            ],
            'finish' => [
                'icon' => '🎊',
                'message' => 'Finalizado! Nossa, que demora, hein?'
            ],
            'order_fulfilled' => [
                'icon' => '🎵',
                'message' => 'Vamos atender! Que vibe, hein?'
            ],
            'order_canceled' => [
                'icon' => '🚫',
                'message' => 'Vamos cancelar! Triste, acontece.'
            ],
            'dependencies' => [
                'icon' => '⛓️',
                'message' => 'Tire os vínculos antes! Se não dá ruim...'
            ],
            'error' => [
                'icon' => '❌',
                'message' => 'Algo deu errado!'
            ],
        ];

        $base = $messages[$action] ?? $messages['save'];
        $final =  $base['message'];

        return redirect()->to(request()->fullUrl())->with('flash', [
            'icon' => $base['icon'],
            'message' => $final,
        ]);
    }
}
