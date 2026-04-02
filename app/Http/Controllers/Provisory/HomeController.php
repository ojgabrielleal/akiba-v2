<?php

namespace App\Http\Controllers\Provisory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Onair;
use App\Http\Resources\OnairResource;

class HomeController extends Controller
{
    private $render = 'provisory/Home';

    public function showOnair()
    {
        return OnairResource::collection(Onair::live()->get());
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'onair' => $this->showOnair()
        ]);
    }
}
