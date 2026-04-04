<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Onair;
use App\Models\Program;
use App\Models\Automatic;
use App\Models\SongRequest;

use App\Http\Resources\OnairResource;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\SongRequestResource;

use App\Services\External\DiscordWebhookService;
use App\Traits\HasFlashMessages;

class LocutionController extends Controller
{
    use HasFlashMessages;

    private DiscordWebhookService $discord;
    private $render = 'private/Locution';

    public function __construct(DiscordWebhookService $discord)
    {
        $this->discord = $discord;
    }

    public function indexPrograms()
    {
        if (request()->user()->cannot('viewAny', Program::class)) {
            return null;
        }
        return ProgramResource::collection(
            Program::active()
                ->where(function ($q) {
                    $q->where('user_id', request()->user()->id)
                        ->orWhere('type', 'free');
                })
                ->get()
        );
    }

    public function indexSongRequests()
    {
        if (request()->user()->cannot('viewAny', SongRequest::class)) {
            return null;
        }

        $onair = Onair::live()->first();

        return SongRequestResource::collection(
            SongRequest::where('onair_id', $onair->id)
                ->where('was_canceled', false)
                ->where('was_reproduced', false)
                ->orderBy('created_at', 'asc')
                ->get()
        );
    }

    public function showOnair()
    {
        return new OnairResource(
            Onair::live()->with('program.host')->first()
        );
    }

    public function startLocution(Request $request, Program $program)
    {
        if ($request->user()->cannot('locution.start')) {
            return null;
        }
        $request->validate([
            'phrase' => 'required',
            'icon' => 'required'
        ]);

        Onair::live()->first()->update([
            'in_air' => false,
            'song_requests_total' => false,
        ]);

        if ($program->type === 'free') {
            $program->update([
                'user_id' => request()->user()->id
            ]);
        }

        $program->onair()->create([
            'type' => 'live',
            'phrase' => $request->input('phrase'),
            'icon' => $request->input('icon'),
            'allows_song_requests' => true,
        ]);

        $this->discord->sendHookMessage(request()->user(), $program);
        return $this->flashMessage('start');
    }

    public function finishLocution()
    {
        if (request()->user()->cannot('locution.finish')) {
            return null;
        }
        $onair = Onair::live()->first();
        $onair->update([
            'in_air' => false,
            'allows_song_requests' => false,
        ]);

        $auto = Automatic::where('is_default', true)->first();
        $selected = collect($auto->phrases)->random();

        $auto->onair()->create([
            'type'   => 'automatic',
            'phrase' => $selected['phrase'],
            'icon'  => $selected['image'],
        ]);

        SongRequest::where('onair_id', $onair->id)
            ->where('was_reproduced', false)
            ->where('was_canceled', false)
            ->update([
                'was_canceled' => true,
            ]);

        return $this->flashMessage('finish');
    }

    public function markSongRequestAsPlayed(SongRequest $songRequest)
    {
        if (request()->user()->cannot('update', $songRequest)) {
            return null;
        }
        $songRequest->update([
            'was_reproduced' => true,
        ]);

        $songRequest->onair()->increment('song_requests_total');
        return $this->flashMessage('order_fulfilled');
    }

    public function markSongRequestAsCanceled(SongRequest $songRequest)
    {
        if (request()->user()->cannot('update', $songRequest)) {
            return null;
        }
        $songRequest->update([
            'was_canceled' => true,
        ]);

        $songRequest->onair()->decrement('song_requests_total');
        return $this->flashMessage('order_canceled');
    }


    public function toggleSongRequestBoxStatus()
    {
        if (request()->user()->cannot('update', SongRequest::class)) {
            return null;
        }
        $onair = Onair::live()->first();
        $onair->update([
            'allows_song_requests' => !$onair->allows_song_requests,
        ]);

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "onair" => $this->showOnair(),
            "songrequests" => $this->indexSongRequests(),
        ]);
    }
}
