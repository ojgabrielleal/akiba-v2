<?php

namespace App\Actions\Event;

use App\Models\Event;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class UpdateEventAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Event $event, array $data, ?UploadedFile $imageFile, ?UploadedFile $coverFile): Event
    {
        $event->fill([
            'image' => $this->image->store('events', $imageFile, 'public', $event->image),
            'cover' => $this->image->store('events', $coverFile, 'public', $event->cover),
            'title' => $data['title'] ?? $event->title,
            'content' => $data['content'] ?? $event->content,
            'dates' => $data['dates'] ?? $event->dates,
            'address' => $data['address'] ?? $event->address,
        ]);

        if ($event->isDirty()) {
            $event->save();
        }

        return $event;
    }
}
