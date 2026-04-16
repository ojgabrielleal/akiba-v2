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

    private $radioStats;
    private $render = 'private/Logs';

    public function __construct(RadiosStatsService $radioStats)
    {
        $this->radioStats = $radioStats;
    }

    /**
     * Renderiza a página de Logs com as estatísticas de audiência.
     */
    public function render()
    {
        return Inertia::render($this->render, [
            'audienceStats' => $this->radioStats->getStats()
        ]);
    }
}
