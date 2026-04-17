<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Activity;
use App\Models\Calendar;
use App\Models\Task;
use App\Models\Automatic;

use App\Http\Requests\Administration\StoreActivityRequest;
use App\Http\Requests\Administration\UpdateActivityRequest;
use App\Http\Requests\Administration\UpdateCalendarRequest;
use App\Http\Requests\Administration\UpdateTaskRequest;
use App\Http\Requests\Administration\UpdateUserAccessRequest;
use App\Http\Requests\Administration\UpdateRoleRequest;

use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\AutomaticResource;

use App\Exceptions\RoleHasMembersException;
use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class AdministrationController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Administration';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    /*
     * ======================
     * ACTIVITIES
     * ====================== 
     */

    public function indexActivities()
    {
        if (request()->user()->cannot('viewAny', Activity::class)) return null;

        return ActivityResource::collection(
            Activity::valid()->with(['author', 'confirmations'])->latest()->get()
        );
    }

    public function showActivity(Activity $activity)
    {
        if (request()->user()->cannot('view', $activity)) return null;

        return new ActivityResource(
            $activity->load(['author', 'confirmations', 'calendar'])
        );
    }

    public function createActivity(StoreActivityRequest $request)
    {
        if ($request->user()->cannot('create', Activity::class)) return null;

        $activity = Activity::create([
            'user_id' => request()->user()->id,
            'title' => $request->input('title'),
            'limit' => $request->input('limit'),
            'content' => $request->input('content'),
            'allows_confirmations' => $request->input('purpose') === 'activity',
        ]);

        if ($request->input('purpose') === 'activity') {
            $activity->calendar()->create([
                'user_id' => request()->user()->id,
                'has_activity' => true,
                'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
                'hour' => $request->input('hour'),
                'date' => $request->input('date'),
                'content' => $request->input('title'),
                'type' => 'activity',
            ]);
        }

        return $this->flashMessage('save');
    }

    public function updateActivity(UpdateActivityRequest $request, Activity $activity)
    {
        if ($request->user()->cannot('update', $activity)) return null;

        $activity->fill([
            'title' => $request->input('title'),
            'limit' => $request->input('limit'),
            'content' => $request->input('content'),
            'allows_confirmations' => $request->input('purpose') === 'activity'
                ? $request->boolean('allows_confirmations')
                : false
        ]);

        if ($activity->isDirty()) $activity->save();

        if ($request->input('purpose') === 'activity') {
            $activity->calendar()->updateOrCreate(
                ['activity_id' => $activity->id],
                [
                    'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
                    'hour' => $request->input('hour'),
                    'date' => $request->input('date'),
                    'content' => $request->input('title'),
                    'type' => 'activity',
                    'user_id' => request()->user()->id,
                    'has_activity' => true,
                ]
            );
        } else {
            $activity->calendar()->delete();
        }

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * CALENDAR
     * ====================== 
     */

    public function indexCalendar()
    {
        if (request()->user()->cannot('viewAny', Calendar::class)) return null;

        return CalendarResource::collection(Calendar::valid()->get());
    }

    public function showCalendar(Calendar $calendar)
    {
        if (request()->user()->cannot('view', $calendar)) return null;

        return new CalendarResource($calendar->load(['activity', 'responsible']));
    }

    public function createCalendar(Request $request)
    {
        if (request()->user()->cannot('create', Calendar::class)) return null;

        $user = User::where('uuid', $request->input('user'))->first();

        Calendar::create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
            'date' => $request->input('date'),
            'hour' => $request->input('hour'),
            'type' => $request->input('type'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateCalendar(UpdateCalendarRequest $request, Calendar $calendar)
    {
        if ($request->user()->cannot('update', $calendar)) return null;

        $user = User::where('uuid', $request->input('user'))->first();

        $calendar->fill([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
            'date' => $request->input('date'),
            'hour' => $request->input('hour'),
            'type' => $request->input('type'),
        ]);

        if ($calendar->isDirty()) $calendar->save();

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * TASKS
     * ====================== 
     */

    public function indexTask()
    {
        if (request()->user()->cannot('viewAny', Task::class)) return null;

        return TaskResource::collection(Task::incompleted()->get());
    }

    public function showTask(Task $task)
    {
        if (request()->user()->cannot('view', $task)) return null;

        return new TaskResource($task->load(['responsible']));
    }

    public function createTask(Request $request)
    {
        if (request()->user()->cannot('create', Task::class)) return null;

        $user = User::where('uuid', $request->input('user'))->first();

        Task::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'dead_line' => $request->input('dead_line'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateTask(UpdateTaskRequest $request, Task $task)
    {
        if (request()->user()->cannot('update', $task)) return null;

        $user = User::where('uuid', $request->input('user'))->first();

        $task->fill([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'dead_line' => $request->input('dead_line'),
            'content' => $request->input('content'),
        ]);

        if ($task->isDirty()) $task->save();

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * USERS
     * ====================== 
     */

    public function indexUsers()
    {
        if (request()->user()->cannot('viewAny', User::class)) return null;

        return UserResource::collection(User::active()->with(['roles'])->get());
    }

    public function showUser(User $user)
    {
        if (request()->user()->cannot('view', $user)) return null;

        return new UserResource($user);
    }

    public function createUser(Request $request)
    {
        if ($request->user()->cannot('create', User::class)) return null;

        

        $roles = Role::whereIn('name', $request->input('roles'))->pluck('id');
        $avatar = $request->input('gender') === 'male'
            ? '/img/users/avatarMale.webp'
            : '/img/users/avatarFemale.webp';

        $user = User::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'name' => $request->input('name'),
            'avatar' => $avatar,
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
        ]);

        $user->roles()->attach($roles);

        return $this->flashMessage('save');
    }

    public function updateUserAccess(UpdateUserAccessRequest $request, User $user)
    {
        if ($request->user()->cannot('updateAuthority', $user)) return null;

        $roles = Role::whereIn('name', $request->input('roles'))->pluck('id')->toArray();

        $user->update(['password' => $request->input('password')]);
        $user->roles()->sync($roles);

        return $this->flashMessage('save');
    }

    public function deactivateUser(User $user)
    {
        if (request()->user()->cannot('delete', $user)) return null;

        $user->update(['is_active' => false]);

        return $this->flashMessage('deactivate');
    }

    /*
     * ======================
     * ROLES & PERMISSIONS
     * ====================== 
     */

    public function indexRole()
    {
        if (request()->user()->cannot('viewAny', Role::class)) return null;

        return RoleResource::collection(Role::with(['permissions', 'members'])->get());
    }

    public function showRole(Role $role)
    {
        if (request()->user()->cannot('view', $role)) return null;

        return new RoleResource($role);
    }

    public function indexPermissions()
    {
        if (request()->user()->cannot('viewAny', Role::class)) return null;

        return PermissionResource::collection(Permission::all());
    }

    public function createRole(Request $request)
    {
        if ($request->user()->cannot('create', Role::class)) return null;

        $role = Role::create([
            'label' => $request->input('label'),
            'name' => Str::slug($request->input('label')),
            'weight' => $request->input('weight'),
            'description' => $request->input('description'),
        ]);

        $permissions = Permission::whereIn('uuid', $request->input('permissions'))->pluck('id')->toArray();
        $role->permissions()->sync($permissions);

        return $this->flashMessage('save');
    }

    public function updateRole(UpdateRoleRequest $request, Role $role)
    {
        if ($request->user()->cannot('update', $role)) return null;

        $role->fill([
            'label' => $request->input('label'),
            'name' => Str::slug($request->input('label')),
            'weight' => $request->input('weight'),
            'description' => $request->input('description'),
        ]);

        if ($role->isDirty()) $role->save();

        $permissions = Permission::whereIn('uuid', $request->input('permissions'))->pluck('id')->toArray();
        $role->permissions()->sync($permissions);

        return $this->flashMessage('update');
    }

    public function removeRole(Role $role)
    {
        if (request()->user()->cannot('delete', $role)) return null;

        if ($role->members()->count() > 0) throw new RoleHasMembersException();

        $role->delete();

        return $this->flashMessage('delete');
    }

    /*
     * ======================
     * AUTOMATICS
     * ====================== 
     */

    public function indexAutomatic()
    {
        if (request()->user()->cannot('viewAny', Automatic::class)) return null;

        return AutomaticResource::collection(
            Automatic::active()->with('host')->get()
        );
    }

    public function showAutomatic(Automatic $automatic)
    {
        if (request()->user()->cannot('view', $automatic)) return null;

        return new AutomaticResource($automatic->load('host'));
    }

    public function createAutomatic(Request $request)
    {
        if (request()->user()->cannot('create', Automatic::class)) return null;

        $user = User::where('uuid', $request->input('user'))->first();

        Automatic::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'image' => $this->image->store('programs', $request->file('image'), 'public'),
            'phrases' => $request->input('phrases'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateAutomatic(Request $request, Automatic $automatic)
    {
        if ($request->user()->cannot('update', $automatic)) return null;

        $user = User::where('uuid', $request->input('user'))->first();

        $automatic->fill([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'image' => $this->image->store('programs', $request->file('image'), 'public', $automatic->image),
            'phrases' => $request->input('phrases'),
        ]);

        if ($automatic->isDirty()) $automatic->save();

        return $this->flashMessage('update');
    }

    public function deactivateAutomatic(Automatic $automatic)
    {
        if (request()->user()->cannot('delete', $automatic)) return null;

        $automatic->update(['is_active' => false]);

        return $this->flashMessage('deactivate');
    }

    /**
     * ======================
     * RENDER
     * ====================== 
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'roles' => $this->indexRole(),
            'permissions' => $this->indexPermissions(),
            'activities' => $this->indexActivities(),
            'calendar' => $this->indexCalendar(),
            'users' => $this->indexUsers(),
            'tasks' => $this->indexTask(),
            'automatics' => $this->indexAutomatic(),
        ]);
    }
}
