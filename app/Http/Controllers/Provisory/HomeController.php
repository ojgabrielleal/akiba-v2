<?php

namespace App\Http\Controllers\Provisory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

use App\Services\External\CastService;

use App\Models\Onair;
use App\Http\Resources\OnairResource;

class HomeController extends Controller
{
    private $render = 'provisory/Home';

    protected $cast;

    public function __construct(CastService $cast)
    {
        $this->cast = $cast;
    }

    public function showOnair()
    {
        $cast = $this->cast->data();
        
        // get() retorna uma coleção
        $onair = Onair::live()->with('program')->get();
        $onair->each(function ($item) use ($cast) {
            $item->current_song = $cast['current_song'] ?? null;
        });
        return OnairResource::collection($onair);
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'onair' => $this->showOnair()
        ]);
    }
}
