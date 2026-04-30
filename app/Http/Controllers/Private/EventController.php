<?php

namespace App\Http\Controllers\Private;

use App\Actions\Event\CreateEventAction;
use App\Actions\Event\UpdateEventAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Traits\HasFlashMessages;
use Inertia\Inertia;

class EventController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Event';

    /*
     * ======================
     * EVENTS
     * ======================
     */

    public function indexEvents()
    {
        if (request()->user()->cannot('viewAny', Event::class)) {
            return null;
        }

        return EventResource::collection(
            Event::active()
                ->with(['author', 'views'])
                ->paginate(10)
        );
    }

    public function showEvent(Event $event)
    {
        if (request()->user()->cannot('view', $event)) {
            return null;
        }

        return Inertia::render($this->render, [
            'event' => new EventResource($event->load('author')),
            'events' => $this->indexEvents(),
        ]);
    }

    public function createEvent(CreateEventRequest $request, CreateEventAction $createEventAction)
    {
        if ($request->user()->cannot('create', Event::class)) {
            return null;
        }

        $createEventAction->execute(
            $request->user()->id,
            $request->all(),
            $request->file('image'),
            $request->file('cover')
        );

        return $this->flashMessage('save');
    }

    public function updateEvent(UpdateEventRequest $request, Event $event, UpdateEventAction $updateEventAction)
    {
        if ($request->user()->cannot('update', $event)) {
            return null;
        }

        $updateEventAction->execute(
            $event,
            $request->all(),
            $request->file('image'),
            $request->file('cover')
        );

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
