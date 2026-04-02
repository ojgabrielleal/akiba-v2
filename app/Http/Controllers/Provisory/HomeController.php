<?php

namespace App\Http\Controllers\Provisory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    private $render = 'provisory/Home';

    public function render()
    {
        return Inertia::render($this->render);
    }
}
