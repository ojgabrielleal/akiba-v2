<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Event;

use App\Http\Resources\EventResource;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

class EventController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;
    private $render = 'private/Event';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    /*
     * ======================
     * EVENTS
     * ====================== 
     */

    public function indexEvents()
    {
        if (request()->user()->cannot('viewAny', Event::class)) return null;

        return EventResource::collection(
            Event::active()
                ->with('author')
                ->paginate(10)
        );
    }

    public function showEvent(Event $event)
    {
        if (request()->user()->cannot('view', $event)) return null;

        return Inertia::render($this->render, [
            'event' => new EventResource($event->load('author')),
            'events' => $this->indexEvents()
        ]);
    }

    public function createEvent(StoreEventRequest $request)
    {
        if ($request->user()->cannot('create', Event::class)) return null;

        Event::create([
            'user_id' => request()->user()->id,
            'image' => $this->image->store('events', $request->file('image')),
            'cover' => $this->image->store('events', $request->file('cover')),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'dates' => $request->input('dates'),
            'address' => $request->input('address'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateEvent(UpdateEventRequest $request, Event $event)
    {
        if ($request->user()->cannot('update', $event)) return null;

        $event->fill([
            'image' => $this->image->store('events', $request->file('image'), 'public', $event->image),
            'cover' => $this->image->store('events', $request->file('cover'), 'public', $event->cover),
            'title' => $request->input('title', $event->title),
            'content' => $request->input('content', $event->content),
            'dates' => $request->input('dates', $event->dates),
            'address' => $request->input('address', $event->address),
        ]);

        if ($event->isDirty()) $event->save();

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * RENDER
     * ====================== 
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'events' => $this->indexEvents(),
        ]);
    }
}
