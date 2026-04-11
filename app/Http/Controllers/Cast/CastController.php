<?php

namespace App\Http\Controllers\Cast;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Onair;

use App\Http\Resources\OnairResource;
use App\Services\External\CastService;

class CastController extends Controller
{
    protected $cast;

    public function __construct(CastService $cast)
    {
        $this->cast = $cast;
    }

    public function redirectStream()
    {
        return $this->cast->stream();
    }

    public function showMetadata()
    {
        $cast = $this->cast->data();
        
        $onair = Onair::live()->with('program.host')->get();
        $onair->each(function ($item) use ($cast) {
            $item->current_song = $cast['current_song'] ?? null;
        });

        return OnairResource::collection($onair);
    }
}
