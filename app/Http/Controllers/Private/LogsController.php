<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Traits\HasFlashMessages;

use App\Services\External\RadiosStatsService;

class LogsController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Logs';

    /**
     * Renderiza a página de Logs com as estatísticas de audiência.
     */
    public function render(RadiosStatsService $service)
    {
        return Inertia::render($this->render, [
            'audienceStats' => $service->getStats(),
            'isLocal' => app()->isLocal()
        ]);
    }
}
