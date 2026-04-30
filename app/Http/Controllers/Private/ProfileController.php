<?php

namespace App\Http\Controllers\Private;

use App\Actions\Profile\UpdateProfileAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HasFlashMessages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Profile';

    /*
     * ======================
     * PROFILE
     * ======================
     */

    public function updateProfile(Request $request, User $user, UpdateProfileAction $updateProfileAction)
    {
        if ($request->user()->cannot('update', $user)) {
            abort(403, 'Não autorizado.');
        }

        $updateProfileAction->execute(
            $user,
            $request->all(),
            $request->file('avatar')
        );

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
            'profile' => new UserResource($user->load(['favorites', 'socials', 'preferences'])),
        ]);
    }
}
