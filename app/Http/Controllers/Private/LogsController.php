<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Onair;
use App\Http\Resources\OnairResource;

use App\Traits\HasFlashMessages;
use App\Services\External\AudienceService;

class LogsController extends Controller
{
    use HasFlashMessages;

    private $audience;
    private $render = 'private/Logs';

    public function __construct(AudienceService $audience)
    {
        $this->audience = $audience;
    }

    public function indexOnair()
    {
        return OnairResource::collection(
            Onair::where('type', 'live')
                ->orWhere('type', 'schedule')
                ->with(['program.host'])
                ->paginate(10)
        );
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'audience' => $this->audience->getAudience(),
            'onair' => $this->indexOnair()
        ]);
    }
}
