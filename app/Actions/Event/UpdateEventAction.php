<?php

namespace App\Actions\Event;

use App\Models\Event;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateEventAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Event $event, array $data, ?UploadedFile $imageFile, ?UploadedFile $coverFile): Event
    {
        return DB::transaction(function () use ($event, $data, $imageFile, $coverFile) {
            $event->fill([
                'image' => $this->image->store('events', $imageFile, 'public', $event->image),
                'cover' => $this->image->store('events', $coverFile, 'public', $event->cover),
                'title' => array_key_exists('title', $data) ? $data['title'] : $event->title,
                'content' => array_key_exists('content', $data) ? $data['content'] : $event->content,
                'dates' => array_key_exists('dates', $data) ? $data['dates'] : $event->dates,
                'address' => array_key_exists('address', $data) ? $data['address'] : $event->address,
            ]);

            if ($event->isDirty()) {
                $event->save();
            }

            return $event;
        });
    }
}
