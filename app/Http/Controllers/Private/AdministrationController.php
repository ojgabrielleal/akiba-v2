<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;

use App\Exceptions\RoleHasMembersException;

use App\Traits\HasFlashMessages;

class AdministrationController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Administration';

    public function indexRoles()
    {
        return RoleResource::collection(
            Role::with(['permissions', 'members'])->get()
        );
    }

    public function indexPermissions()
    {
        return PermissionResource::collection(
            Permission::all()
        );
    }

    public function indexUsers()
    {
        return UserResource::collection(
            User::active()
                ->with(['roles'])
                ->get()
        );
    }

    public function showRole(Role $role)
    {
        return new RoleResource($role);
    }

    public function showUser(User $user)
    {
        return new UserResource($user);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'label'=> 'required|unique:roles,label',
            'weight'=> 'required',
            'description'=> 'required',
            'permissions'=> 'required'
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

    public function createUser(Request $request)
    {
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

        User::create([
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'name' => $request->input('name'),
            'avatar' => $avatar,
            'nickname' => $request->input('nickname'),
            'gender' => $request->input('gender'),
        ])
        ->roles()->attach($roles)
        ->socials()->createMany($socials)
        ->preferences()->createMany($preferences);

        return $this->flashMessage('save');
    }

    public function deactivateUser(User $user)
    {
        $user->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function updateUserAccess(Request $request, User $user)
    {
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
        $role->fill([
            'label' => $request->input('label'),
            'name' => Str::slug($request->input('label')),
            'weight' => $request->input('weight'),
            'description' => $request->input('description'),
        ]);

        if($role->isDirty()){
            $role->save();
        }

        if($role->permissions()->pluck('uuid')->toArray() != $request->input('permissions')){
            $permissions = Permission::whereIn('uuid', $request->input('permissions'))
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissions);
        }

        return $this->flashMessage('update');
    }

    public function removeRole(Role $role)
    {
        if($role->members()->count() > 0){
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
            'users' => $this->indexUsers()
        ]);
    }
}
