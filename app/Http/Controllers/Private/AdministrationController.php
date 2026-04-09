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

use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\CalendarResource;

use App\Exceptions\RoleHasMembersException;

use App\Traits\HasFlashMessages;

class AdministrationController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Administration';

    public function indexActivities()
    {
        if (request()->user()->cannot('viewAny', Activity::class)) {
            return null;
        }
        return ActivityResource::collection(
            Activity::with(['author', 'confirmations'])
                ->get()
        );
    }

    public function indexRoles()
    {
        if (request()->user()->cannot('viewAny', Role::class)) {
            return null;
        }
        return RoleResource::collection(
            Role::with(['permissions', 'members'])->get()
        );
    }

    public function indexPermissions()
    {
        if (request()->user()->cannot('viewAny', Role::class)) {
            return null;
        }
        return PermissionResource::collection(
            Permission::all()
        );
    }

    public function indexUsers()
    {
        if (request()->user()->cannot('viewAny', User::class)) {
            return null;
        }
        return UserResource::collection(
            User::active()
                ->with(['roles'])
                ->get()
        );
    }

    public function indexCalendar()
    {
        if (request()->user()->cannot('viewAny', Calendar::class)) {
            return null;
        }
        return CalendarResource::collection(
            Calendar::valid()
                ->get()
        );
    }

    public function showRole(Role $role)
    {
        if (request()->user()->cannot('view', $role)) {
            return null;
        }
        return new RoleResource($role);
    }

    public function showUser(User $user)
    {
        if (request()->user()->cannot('view', $user)) {
            return null;
        }
        return new UserResource($user);
    }

    public function showActivity(Activity $activity)
    {
        if (request()->user()->cannot('view', $activity)) {
            return null;
        }
        return new ActivityResource($activity->load(['author', 'confirmations', 'calendar']));
    }

    public function showCalendar(Calendar $calendar)
    {
        if (request()->user()->cannot('view', $calendar)) {
            return null;
        }

        return new CalendarResource($calendar->load(['activity', 'responsible']));
    }

    public function createCalendar(Request $request)
    {
        if (request()->user()->cannot('create', Calendar::class)) {
            return null;
        }

        $request->validate([
            'user' => 'required',
            'content' => 'required',
            'date' => 'required',
            'hour' => 'required',
            'type' => 'required',
        ]);

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

    public function createRole(Request $request)
    {
        if ($request->user()->cannot('create', Role::class)) {
            return null;
        }

        $request->validate([
            'label' => 'required|unique:roles,label',
            'weight' => 'required',
            'description' => 'required',
            'permissions' => 'required'
        ]);

        $role = Role::create([
            'label' => $request->input('label'),
            'name' => Str::slug($request->input('label')),
            'weight' => $request->input('weight'),
            'description' => $request->input('description'),
        ]);

        $permissions = Permission::whereIn('uuid', $request->input('permissions'))
            ->pluck('id')
            ->toArray();

        $role->permissions()->sync($permissions);

        return $this->flashMessage('save');
    }

    public function createActivity(Request $request)
    {
        if ($request->user()->cannot('create', Activity::class)) {
            return null;
        }
        
        $request->validate([
            'title' => 'required',
            'limit' => 'required',
            'content' => 'required'
        ]);

        Activity::create([
            'user_id' => request()->user()->id,
            'title' => $request->input('title'),
            'limit' => $request->input('limit'),
            'content' => $request->input('content'),
            'allows_confirmations' => true,
        ])->calendar()->create([
            'user_id' => request()->user()->id,
            'has_activity' => true,
            'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
            'hour' => $request->input('hour'),
            'date' => $request->input('date'),
            'content' => $request->input('title'),
            'type' => 'activity',
        ]);

        return $this->flashMessage('save');
    }

    public function createUser(Request $request)
    {
        if ($request->user()->cannot('create', User::class)) {
            return null;
        }
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'name' => 'required',
            'nickname' => 'required',
            'gender' => 'required',
            'roles' => 'required'
        ]);

        $roles = Role::whereIn('name', $request->input('roles'))->pluck('id');
        $avatar = $request->input('gender') === 'male' ? '/img/users/default/avatarMale.webp' : '/img/users/default/avatarFemale.webp';

        $socials = [
            ['name' => 'Facebook', 'url' => null],
            ['name' => 'Instagram', 'url' => null],
            ['name' => 'Twitter', 'url' => null],
            ['name' => 'Bluesky', 'url' => null],
            ['name' => 'Discord', 'url' => null],
            ['name' => 'YouTube', 'url' => null],
        ];

        $preferences = [
            ['is_like' => true, 'content' => null],
            ['is_like' => true, 'content' => null],
            ['is_like' => true, 'content' => null],
            ['is_like' => false, 'content' => null],
            ['is_like' => false, 'content' => null],
            ['is_like' => false, 'content' => null],
        ];

        $user = User::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'name' => $request->input('name'),
            'avatar' => $avatar,
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
        ]);

        $user->roles()->attach($roles);
        $user->socials()->createMany($socials);
        $user->preferences()->createMany($preferences);

        return $this->flashMessage('save');
    }

    public function updateCalendar(Request $request, Calendar $calendar)
    {
        if ($request->user()->cannot('update', $calendar)) {
            return null;
        }
        $request->validate([
            'user' => 'required',
            'content' => 'required',
            'date' => 'required',
            'hour' => 'required',
            'type' => 'required',
        ]);

        $user = User::where('uuid', $request->input('user'))->first();

        $calendar->fill([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
            'date' => $request->input('date'),
            'hour' => $request->input('hour'),
            'type' => $request->input('type'),
        ]);

        if($calendar->isDirty()){
            $calendar->save();
        }
        
        return $this->flashMessage('update');
    }

    public function updateUserAccess(Request $request, User $user)
    {
        if ($request->user()->cannot('updateAuthority', $user)) {
            return null;
        }
        $request->validate([
            'password' => 'required',
            'roles' => 'required|array',
        ]);

        $roles = Role::whereIn('name', $request->input('roles'))
            ->pluck('id')
            ->toArray();

        $user->update([
            'password' => $request->input('password'),
        ]);

        $user->roles()->sync($roles);

        return $this->flashMessage('save');
    }

    public function updateRole(Request $request, Role $role)
    {
        if ($request->user()->cannot('update', $role)) {
            return null;
        }
        $role->fill([
            'label' => $request->input('label'),
            'name' => Str::slug($request->input('label')),
            'weight' => $request->input('weight'),
            'description' => $request->input('description'),
        ]);

        if ($role->isDirty()) {
            $role->save();
        }

        if ($role->permissions()->pluck('uuid')->toArray() != $request->input('permissions')) {
            $permissions = Permission::whereIn('uuid', $request->input('permissions'))
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissions);
        }

        return $this->flashMessage('update');
    }

    public function updateActivity(Request $request, Activity $activity)
    {
        if ($request->user()->cannot('update', $activity)) {
            return null;
        }
        $activity->fill([
            'title' => $request->input('title'),
            'limit' => $request->input('limit'),
            'content' => $request->input('content'),
        ]);

        if ($activity->isDirty()) {
            $activity->save();
        }

        $activity->calendar()->update([
            'day_of_week' => Carbon::parse($request->input('date'))->dayOfWeek,
            'hour' => $request->input('hour'),
            'date' => $request->input('date'),
            'content' => $request->input('title'),
        ]);

        return $this->flashMessage('update');
    }

    public function deactivateUser(User $user)
    {
        if (request()->user()->cannot('delete', $user)) {
            return null;
        }
        $user->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function removeRole(Role $role)
    {
        if (request()->user()->cannot('delete', $role)) {
            return null;
        }
        if ($role->members()->count() > 0) {
            throw new RoleHasMembersException();
        }

        $role->delete();
        return $this->flashMessage('delete');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'roles' => $this->indexRoles(),
            'permissions' => $this->indexPermissions(),
            'activities' => $this->indexActivities(),
            'calendar' => $this->indexCalendar(),
            'users' => $this->indexUsers()
        ]);
    }
}
