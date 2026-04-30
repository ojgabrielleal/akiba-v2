<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnairResource;
use App\Models\Onair;
use App\Services\External\AudienceService;
use App\Traits\HasFlashMessages;
use Inertia\Inertia;

class LogsController extends Controller
{
    use HasFlashMessages;

    private $audience;

    private $render = 'private/Logs';

    public function __construct(AudienceService $audience)
    {
        $this->audience = $audience;
    }

    /*
     * ======================
     * ONAIR LOGS
     * ======================
     */

    public function indexOnair()
    {
        return OnairResource::collection(
            Onair::where('type', 'live')
                ->orWhere('type', 'schedule')
                ->with(['program.host'])
                ->latest()
                ->paginate(10)
        );
    }

    /*
     * ======================
     * RENDER
     * ======================
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'audience' => $this->audience->getAudience(),
            'onair' => $this->indexOnair(),
        ]);
    }
}
