<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Music;
use App\Models\Program;
use App\Models\ListenerMonth;

use App\Http\Resources\Private\UserIndexResource;
use App\Http\Resources\Private\ProgramIndexResource;
use App\Http\Resources\Private\ProgramShowResource;
use App\Http\Resources\Private\MusicIndexResource;
use App\Http\Resources\Private\ListenerMonthShowResource;
use App\Http\Resources\Private\ListenerMonthFoundShowResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class RadioController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Radio';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function indexStreamers()
    {
        return UserIndexResource::collection(
            User::get()
        );
    }

    public function indexPrograms()
    {
        return ProgramIndexResource::collection(
            Program::with(['host', 'schedules'])
                ->active()
                ->get()
        );
    }

    public function indexSchedules()
    {
        return ProgramIndexResource::collection(
            Program::with(['host', 'schedules'])
                ->where('type', 'private')
                ->active()
                ->get()
        );
    }

    public function indexMusicRanking()
    {
        return MusicIndexResource::collection(
            Music::orderBy('song_requests_total', 'desc')
                ->limit(3)
                ->get()
        );
    }

    public function showListenerMonth()
    {
        return new ListenerMonthShowResource(
            ListenerMonth::first()
        );
    }

    public function showListenerMonthFound()
    {
        return new ListenerMonthFoundShowResource(
            ListenerMonth::mostActiveListenerOfCurrentMonth()
        );
    }

    public function showProgram(Program $program)
    {
        return new ProgramShowResource($program->load('host', 'schedules'));
    }

    public function updateProgram(Request $request, Program $program)
    {
        $user = User::where('uuid', $request->input('user'))->first();

        $program->fill([
            'user_id' => $user->id,
            'name' => $request->input('name', $program->name),
            'image' => $this->image->store('programs', $request->file('image'), 'public', $program->image),
            'type' => $request->input('type', $program->type),
        ]);

        if ($program->isDirty()) {
            $program->save();
        }

        if ($request->has('schedules')) {
            $schedules = collect($request->input('schedules'));

            $uuidsToKeep = $schedules->pluck('uuid')->filter()->toArray();
            $program->schedules()->whereNotIn('uuid', $uuidsToKeep)->delete();

            foreach ($schedules as $schedule) {
                $program->schedules()->updateOrCreate(
                    ['uuid' => $schedule['uuid'] ?? null],
                    [
                        'day' => $schedule['day'],
                        'hour' => $schedule['hour'],
                    ]
                );
            }
        }

        return $this->flashMessage('update');
    }

    public function updateMusicRanking(Request $request, Music $music)
    {
        $music->update([
            'image_ranking' => $this->image->store('musics/ranking', $request->file('image_ranking'), 'public', $music->image_ranking),
        ]);

        return $this->flashMessage('update');
    }

    public function createListenerMonth(Request $request)
    {
        $request->validate([
            'avatar' => 'required',
        ]);

        $found = ListenerMonth::mostActiveListenerOfCurrentMonth();
        ListenerMonth::updateOrCreate(['id' => 1], [
            'avatar' => $this->image->store('listener-month', $request->file('avatar'), 'public'),
            'name' => $found->name,
            'address' => $found->address,
            'favorite_program' => $found->favorite_program,
            'requests_total' => $found->requests_total,
        ]);

        return $this->flashMessage('save');
    }

    public function createProgram(Request $request)
    {
        $user = User::where('uuid', $request->input('user'))->first();

        $program = Program::create([
            'user_id' => $request->input('type') === 'private'
                ? $user->id
                : $request->user()->id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $this->image->store('programs', $request->file('image'), 'public'),
            'type' => $request->input('type'),
        ]);

        if ($request->input('type') === 'private') {
            foreach ($request->input('schedules') as $schedule) {
                $program->schedules()->create([
                    'day' => $schedule['day'],
                    'hour' => $schedule['hour'],
                ]);
            }
        }

        return $this->flashMessage('save');
    }

    public function deactivateProgram(Program $program)
    {
        $program->update([
            'is_active' => false
        ]);

        return $this->flashMessage('deactivate');
    }

    public function generateMusicRanking()
    {
        Music::ranking()->update([
            'in_ranking' => false
        ]);

        $music = Music::orderBy('song_requests_total', 'desc')->limit(10)->get();
        $music->each(function ($music) {
            $music->update(['in_ranking' => true]);
        });

        return $this->flashMessage('update');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "schedules" => $this->indexSchedules(),
            "streamers" => $this->indexStreamers(),
            "musicranking" => $this->indexMusicRanking(),
            "listenermonth" => $this->showListenerMonth(),
        ]);
    }
}
