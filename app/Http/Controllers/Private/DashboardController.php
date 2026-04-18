<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

use App\Models\Activity;
use App\Models\Calendar;
use App\Models\Post;
use App\Models\Task;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TaskResource;

use App\Traits\HasFlashMessages;

class DashboardController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Dashboard';

    /*
     * ======================
     * ACTIVITIES
     * ====================== 
     */

    public function indexActivities()
    {
        if (request()->user()->cannot('viewAny', Activity::class)) return null;

        $activities = Cache::remember('dashboard_activities', 3600, function () {
            return Activity::valid()
                ->with(['author', 'confirmations'])
                ->latest()
                ->get();
        });

        return ActivityResource::collection($activities);
    }

    public function confirmActivityParticipant(Activity $activity)
    {
        if (request()->user()->cannot('update', $activity)) return null;

        $activity->confirmations()->attach(request()->user()->id);

        return $this->flashMessage('participate');
    }

    /*
     * ======================
     * TASKS
     * ====================== 
     */

    public function indexTasks()
    {
        if (request()->user()->cannot('viewAny', Task::class)) return null;

        return TaskResource::collection(
            Task::active()
                ->incompleted()
                ->mine()
                ->with(['responsible'])
                ->get()
        );
    }

    public function markTaskCompleted(Task $task)
    {
        if (request()->user()->cannot('update', $task)) return null;

        $task->update([
            'is_completed' => true,
        ]);

        return $this->flashMessage('complete');
    }

    /*
     * ======================
     * POSTS
     * ====================== 
     */

    public function indexPosts()
    {
        if (request()->user()->cannot('viewAny', Post::class)) return null;

        $posts = Cache::remember('latest_posts', 3600, function () {
            return Post::active()
                ->published()
                ->latest()
                ->with(['author'])
                ->limit(5)
                ->get();
        });

        return PostResource::collection($posts);
    }

    /*
     * ======================
     * CALENDAR
     * ====================== 
     */

    public function indexCalendar()
    {
        if (request()->user()->cannot('viewAny', Calendar::class)) return null;

        $calendar = Cache::remember('dashboard_calendar', 3600, function () {
            return Calendar::valid()
                ->with(['activity', 'responsible'])
                ->get();
        });

        return CalendarResource::collection($calendar);
    }

    /*
     * ======================
     * RENDER
     * ====================== 
     */

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
