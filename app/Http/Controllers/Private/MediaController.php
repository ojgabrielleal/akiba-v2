<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Event;
use App\Models\Poll;
use App\Models\PollOption;

use App\Http\Resources\Private\PollIndexResource;
use App\Http\Resources\Private\PollShowResource;

use App\Traits\HasFlashMessages;

class MediaController extends Controller
{
    use HasFlashMessages;

    private $render = 'private/Media';

    public function indexPolls()
    {
        return PollIndexResource::collection(
            Poll::active()->get()
        );
    }

    public function indexEvents()
    {
        return Event::active()->get();
    }

    public function showPoll(Poll $poll)
    {
        return new PollShowResource($poll);
    }

    public function createVote(PollOption $pollOption)
    {
        $pollOption->increment('votes');
        return $this->flashMessage('save');
    }

    public function createPoll(Request $request)
    {
        $request->validate([
            'question' => 'required|unique:polls,question',
            'option_one' => 'required',
            'option_two' => 'required',
            'option_three' => 'required',
            'option_four' => 'required'
        ]);

        $poll = Poll::create([
            'question' => $request->input('question'),
        ]);

        $options = [
            $request->input('option_one'),
            $request->input('option_two'),
            $request->input('option_three'),
            $request->input('option_four'),
        ];

        foreach ($options as $text) {
            $poll->load('options')->options()->create([
                'option' => $text
            ]);
        }

        return $this->flashMessage('save');
    }

    public function updatePoll(Request $request, Poll $poll)
    {
        $request->validate([
            'question' => 'required',
            'option_one' => 'required',
            'option_two' => 'required',
            'option_three' => 'required',
            'option_four' => 'required'
        ]);

        $poll->update([
            'question' => $request->input('question'),
        ]);

        $poll->load('options');
        $options = $poll->options->values();
        $mapped = [
            'option_one'   => $options->get(0),
            'option_two'   => $options->get(1),
            'option_three' => $options->get(2),
            'option_four'  => $options->get(3),
        ];

        foreach ($mapped as $key => $option) {
            if ($option) {
                $option->update([
                    'option' => $request->input($key)
                ]);
            }
        }

        return $this->flashMessage('update');
    }

    public function deactivatePoll(Poll $poll)
    {
        $poll->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function deactivateEvent(Event $event)
    {
        $event->update([
            'is_active' => false,
        ]);

        return $this->flashMessage('deactivate');
    }

    public function render()
    {
        return Inertia::render($this->render, [
            'polls' => $this->indexPolls(),
            'events' => $this->indexEvents()
        ]);
    }
}
