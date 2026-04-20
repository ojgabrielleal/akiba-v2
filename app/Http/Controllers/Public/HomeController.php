<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Onair;
use App\Models\Music;
use App\Models\Post;

use App\Http\Resources\OnairResource;
use App\Http\Resources\PostResource;

use App\Services\External\CastService;

class HomeController extends Controller
{
    private $render = 'public/Home';
    protected $cast;

    public function __construct(CastService $cast)
    {
        $this->cast = $cast;
    }

    public function indexFeaturedPosts()
    {
        return PostResource::collection(Post::limit(3)->get());
    }

    public function showOnair()
    {
        $cast = $this->cast->data();
        
        // get() retorna uma coleção
        $onair = Onair::live()->with('program.host')->get();
        $onair->each(function ($item) use ($cast) {
            $item->current_song = $cast['current_song'] ?? null;
        });
        return OnairResource::collection($onair);
    }

    public function createSongRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'anime' => 'required',
            'music' => 'required',
            'message' => 'required',
        ]);

        $onair = Onair::live()->first();

        $music = Music::where('name', $request->input('music.name'))->first();
        if (!$music) {
            $music = Music::create([
                'production' => $request->input('anime.title'),
                'type' => $request->input('music.type'),
                'artist' => $request->input('music.artist'),
                'name' => $request->input('music.name'),
                'image' => $request->input('anime.image'),
            ]);
        } else {
            $music->increment('song_requests_total');
        }

        $onair->songRequests()->create([
            'ip' => $request->ip(),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'message' => $request->input('message'),
            'music_id' => $music->id,
        ]);

        return back(303);
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'posts' => $this->indexFeaturedPosts(),
            'onair' => $this->showOnair()
        ]);
    }
}
