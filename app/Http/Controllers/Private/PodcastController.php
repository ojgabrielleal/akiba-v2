<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Podcast;

use App\Http\Requests\Podcast\StorePodcastRequest;

use App\Http\Resources\PodcastResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class PodcastController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Podcast';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    /*
     * ======================
     * PODCASTS
     * ====================== 
     */

    public function indexPodcasts()
    {
        if (request()->user()->cannot('viewAny', Podcast::class)) return null;

        return PodcastResource::collection(
            Podcast::active()
                ->with('author')
                ->paginate(10)
        );
    }

    public function showPodcast(Podcast $podcast)
    {
        if (request()->user()->cannot('view', $podcast)) return null;

        return Inertia::render($this->render, [
            'podcasts' => $this->indexPodcasts(),
            'podcast' => new PodcastResource($podcast->load('author')),
        ]);
    }

    public function createPodcast(StorePodcastRequest $request)
    {
        if ($request->user()->cannot('create', Podcast::class)) return null;

        Podcast::create([
            'user_id' => request()->user()->id,
            'image' => $this->image->store('podcasts', $request->file('image')),
            'season' => $request->input('season'),
            'episode' => $request->input('episode'),
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'description' => $request->input('description'),
            'audio' => $request->input('audio'),
        ]);

        return $this->flashMessage('save');
    }

    public function updatePodcast(Request $request, Podcast $podcast)
    {
        if ($request->user()->cannot('update', $podcast)) return null;

        $podcast->fill([
            'image' => $this->image->store('podcasts', $request->file('image'), 'public', $podcast->image),
            'season' => $request->input('season', $podcast->season),
            'episode' => $request->input('episode', $podcast->episode),
            'title' => $request->input('title', $podcast->title),
            'summary' => $request->input('summary', $podcast->summary),
            'description' => $request->input('description', $podcast->description),
            'audio' => $request->input('audio', $podcast->audio),
        ]);

        if ($podcast->isDirty()) $podcast->save();

        return $this->flashMessage('update');
    }

    public function deactivatePodcast(Podcast $podcast)
    {
        if (request()->user()->cannot('delete', $podcast)) return null;

        $podcast->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    /*
     * ======================
     * RENDER
     * ====================== 
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'podcasts' => $this->indexPodcasts(),
        ]);
    }
}
