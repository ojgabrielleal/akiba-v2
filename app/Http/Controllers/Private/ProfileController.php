<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\User;

use App\Http\Resources\UserResource;

use App\Services\Process\ImageProcessService;

use App\Traits\HasFlashMessages;

class ProfileController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Profile';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    /*
     * ======================
     * PROFILE
     * ====================== 
     */

    public function updateProfile(Request $request, User $user)
    {
        if ($request->user()->cannot('update', $user)) {
            abort(403, 'Não autorizado.');
        }

        $user->fill([
            'avatar' => $this->image->store('users', $request->file('avatar'), 'public', $user->avatar),
            'is_auto' => $request->input('is_auto', $user->is_auto),
            'name' => $request->input('name', $user->name),
            'nickname' => $request->input('nickname', $user->nickname),
            'gender' => $request->input('gender', $user->gender),
            'birthday' => $request->input('birthday', $user->birthday),
            'city' => $request->input('city', $user->city),
            'state' => $request->input('state', $user->state),
            'country' => $request->input('country', $user->country),
            'bibliography' => $request->input('bibliography', $user->bibliography),
        ]);

        if ($user->isDirty()) $user->save();

        if ($request->filled('socials')) {
            foreach ($request->input('socials') as $social) {
                $user->socials()->where('uuid', $social['uuid'])->update([
                    'name' => $social['name'],
                    'url' => $social['url']
                ]);
            }
        }

        if ($request->input('preferences')) {
            $preferences = $request->input('preferences');

            foreach (collect($preferences['likes'])->merge($preferences['unlikes']) as $preference) {
                $user->preferences()->where('uuid', $preference['uuid'])->update([
                    'content' => $preference['content']
                ]);
            }
        }

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * RENDER
     * ====================== 
     */

    public function render(User $user)
    {
        if (request()->user()->cannot('view', $user)) {
            abort(403, 'Não autorizado.');
        }

        return Inertia::render($this->render, [
            'profile' => new UserResource($user)
        ]);
    }
}
