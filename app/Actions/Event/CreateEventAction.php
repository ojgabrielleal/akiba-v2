<?php

namespace App\Actions\Event;

use App\Models\Event;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateEventAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(string $userId, array $data, ?UploadedFile $imageFile, ?UploadedFile $coverFile): Event
    {
        return DB::transaction(fn () => Event::create([
            'user_id' => $userId,
            'image' => $this->image->store('events', $imageFile),
            'cover' => $this->image->store('events', $coverFile),
            'title' => $data['title'] ?? null,
            'content' => $data['content'] ?? null,
            'dates' => $data['dates'] ?? null,
            'address' => $data['address'] ?? null,
        ]));
    }
}
