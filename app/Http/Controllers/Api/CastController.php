<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    /*
    * ======================
    * STREAM
    * ====================== 
    */

    public function redirectStream()
    {
        return $this->cast->stream();
    }

    /*
    * ======================
    * METADATA
    * ====================== 
    */

    public function showMetadata()
    {
        $cast = $this->cast->data();
        
        $onair = Cache::remember('radio_onair_data', 3600, function () {
            return Onair::live()->with('program.host')->get();
        });

        $onair->each(function ($item) use ($cast) {
            $item->current_song = $cast['current_song'] ?? null;
        });

        return OnairResource::collection($onair);
    }
}
