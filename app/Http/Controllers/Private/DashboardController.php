<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Inertia\Inertia;


use App\Models\Activity;
use App\Models\Post;
use App\Models\Task;
use App\Models\Calendar;

use App\Http\Resources\Private\ActivityIndexResource;
use App\Http\Resources\Private\TaskIndexResource;
use App\Http\Resources\Private\PostIndexResource;
use App\Http\Resources\Private\CalendarIndexResource;

use App\Traits\HasFlashMessages;

class DashboardController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Dashboard';

    public function indexActivities()
    {
        return ActivityIndexResource::collection(
            Activity::valid()
                ->with(['author', 'confirmations'])
                ->limit(10)
                ->get()
        );
    }

    public function indexTasks()
    {
        return TaskIndexResource::collection(
            Task::active()
                ->incompleted()
                ->mine()
                ->with(['responsible'])
                ->get()
        );
    }

    public function indexPosts()
    {
        return PostIndexResource::collection(
            Post::active()
                ->published()
                ->latest()
                ->with(['author'])
                ->paginate(5)
        );
    }

    public function indexCalendar()
    {
        return CalendarIndexResource::collection(
            Calendar::active()
                ->with(['activity', 'responsible'])
                ->get()
        );
    }

    public function confirmActivityParticipant(Activity $activity)
    {
        $activity->confirmations()->attach(request()->user()->id);
        return $this->flashMessage('participate');
    }

    public function markTaskCompleted(Task $task)
    {
        $task->update([
            'is_completed' => true,
        ]);

        return $this->flashMessage('complete');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'activities' => $this->indexActivities(),
            'tasks' => $this->indexTasks(),
            'posts' => $this->indexPosts(),
            'calendar' => $this->indexCalendar()
        ]);
    }
}
