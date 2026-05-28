<?php

namespace App\Http\Controllers\Private;

use App\Actions\Radio\CreateListenerMonthAction;
use App\Actions\Radio\CreateProgramAction;
use App\Actions\Radio\GenerateMusicRankingAction;
use App\Actions\Radio\UpdateMusicRankingAction;
use App\Actions\Radio\UpdateProgramAction;
use App\Http\Controllers\Concerns\HasFlashMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Radio\CreateProgramRequest;
use App\Http\Resources\ListenerMonthResource;
use App\Http\Resources\MusicResource;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\UserResource;
use App\Models\ListenerMonth;
use App\Models\Music;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RadioController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Radio';

    /*
     * ======================
     * USERS
     * ======================
     */

    public function indexUsers()
    {
        if (request()->user()->cannot('viewAny', User::class)) {
            return null;
        }

        return UserResource::collection(User::get());
    }

    /*
     * ======================
     * PROGRAMS
     * ======================
     */

    public function indexPrograms()
    {
        if (request()->user()->cannot('viewAny', Program::class)) {
            return null;
        }

        return ProgramResource::collection(
            Program::with(['host', 'schedules'])
                ->active()
                ->get()
        );
    }

    public function createProgram(CreateProgramRequest $request, CreateProgramAction $createProgramAction)
    {
        if ($request->user()->cannot('create', Program::class)) {
            return null;
        }

        Log::info($request->all());

        $createProgramAction->execute(
            $request->user(),
            $request->all(),
            $request->file('image')
        );

        return $this->flashMessage('save');
    }

    public function updateProgram(Request $request, Program $program, UpdateProgramAction $updateProgramAction)
    {
        if ($request->user()->cannot('update', $program)) {
            return null;
        }

        $updateProgramAction->execute(
            $program,
            $request->all(),
            $request->file('image')
        );

        return $this->flashMessage('update');
    }

    public function deactivateProgram(Program $program)
    {
        if (request()->user()->cannot('delete', $program)) {
            return null;
        }

        $program->update(['is_active' => false]);

        return $this->flashMessage('deactivate');
    }

    /*
     * ======================
     * MUSIC
     * ======================
     */

    public function indexMusicRanking()
    {
        if (request()->user()->cannot('viewAny', Music::class)) {
            return null;
        }

        return MusicResource::collection(
            Music::orderBy('song_requests_total', 'desc')
                ->limit(3)
                ->get()
        );
    }

    public function updateMusicRanking(Request $request, Music $music, UpdateMusicRankingAction $updateMusicRankingAction)
    {
        if ($request->user()->cannot('update', $music)) {
            return null;
        }

        $updateMusicRankingAction->execute(
            $music,
            $request->file('image_ranking')
        );

        return $this->flashMessage('update');
    }

    public function generateMusicRanking(GenerateMusicRankingAction $generateMusicRankingAction)
    {
        if (request()->user()->cannot('setRanking', Music::class)) {
            return null;
        }

        $generateMusicRankingAction->execute();

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * LISTENER MONTH
     * ======================
     */

    public function showListenerMonth()
    {
        if (request()->user()->cannot('listener.month.view')) {
            return null;
        }

        $listener = ListenerMonth::first();

        return $listener ? new ListenerMonthResource($listener) : null;
    }

    public function showListenerMonthFound()
    {
        if (request()->user()->cannot('listener.month.view')) {
            return null;
        }

        $listener = ListenerMonth::mostActiveListenerOfCurrentMonth();

        return $listener ? new ListenerMonthResource($listener) : null;
    }

    public function createListenerMonth(Request $request, CreateListenerMonthAction $createListenerMonthAction)
    {
        if ($request->user()->cannot('listener.month.set')) {
            return null;
        }

        $createListenerMonthAction->execute(
            $request->file('avatar')
        );

        return $this->flashMessage('save');
    }

    /*
     * ======================
     *  RENDER
     * ======================
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'users' => $this->indexUsers(),
            'programs' => $this->indexPrograms(),
            'musicRanking' => $this->indexMusicRanking(),
            'listenerMonth' => $this->showListenerMonth(),
        ]);
    }
}
