<?php

namespace App\Actions\Administration\Automatic;

use App\Models\Automatic;
use App\Models\User;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class CreateAutomaticAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(array $data, ?UploadedFile $imageFile): Automatic
    {
        $user = User::where('uuid', $data['user'] ?? '')->first();

        return Automatic::create([
            'user_id' => $user ? $user->id : null,
            'name' => $data['name'] ?? null,
            'image' => $this->image->store('programs', $imageFile, 'public'),
            'phrases' => $data['phrases'] ?? null,
        ]);
    }
}
