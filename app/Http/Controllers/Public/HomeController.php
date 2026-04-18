<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    private $render = 'public/Home';

    public function render()
    {
        return Inertia::render($this->render);
    }
}
