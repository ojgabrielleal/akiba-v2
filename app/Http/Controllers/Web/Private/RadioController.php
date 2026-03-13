<?php

namespace App\Http\Controllers\Web\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Music;
use App\Models\Program;
use App\Models\ProgramSchedule;
use App\Models\ListenerMonth;

use App\Http\Resources\UserIndexResource;
use App\Http\Resources\ProgramIndexResource;
use App\Http\Resources\ProgramShowResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;
use Illuminate\Support\Facades\Log;

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
        return Music::ranking()
            ->orderBy('song_requests_total', 'desc')
            ->limit(3)
            ->get();
    }

    public function indexListenerMonth()
    {
        return ListenerMonth::first();
    }

    public function showListenerMonthFound()
    {
        $found = ListenerMonth::mostActiveListenerOfCurrentMonth();

        return Inertia::render($this->render, [
            'listenerMonthFound' => $found,
        ]);
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
                        'day'  => $schedule['day'],
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
            'image' => 'required',
        ]);

        $found = ListenerMonth::mostActiveListenerOfCurrentMonth();
        ListenerMonth::updateOrCreate(['id' => 1], [
            'image' => $this->image->store('listener-month', $request->file('image'), 'public'),
            'listener' => $found->listener,
            'address' => $found->address,
            'favorite_program' => $found->favorite_program,
            'requests_count' => $found->count,
        ]);

        return $this->flashMessage('save');
    }

    public function createProgram(Request $request)
    {
        Log::info($request->all());

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

        return $this->flashMessage('save');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            "programs" => $this->indexPrograms(),
            "schedules" => $this->indexSchedules(),
            "streamers" => $this->indexStreamers(),
            "musicRanking" => $this->indexMusicRanking(),
            "listenerMonth" => $this->indexListenerMonth(),
        ]);
    }
}
