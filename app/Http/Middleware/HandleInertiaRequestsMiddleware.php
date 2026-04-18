<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

use App\Services\External\CastService;

use App\Traits\ResolvesUserLogged;

class HandleInertiaRequestsMiddleware extends Middleware
{
    use ResolvesUserLogged;

    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     */

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => $this->getUserLogged(),
            'streaming' => (new CastService())->data(),
            'csrf_token' => csrf_token(),
            'flash' => [
                'icon' => session('flash.icon'),
                'message' => session('flash.message'),
            ],
        ]);
    }

}
