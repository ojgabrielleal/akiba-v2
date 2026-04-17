<?php

namespace App\Actions\Administration\Automatic;

use App\Models\Automatic;
use App\Models\User;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class UpdateAutomaticAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Automatic $automatic, array $data, ?UploadedFile $imageFile): Automatic
    {
        $user = User::where('uuid', $data['user'] ?? '')->first();

        $automatic->fill([
            'user_id' => $user ? $user->id : $automatic->user_id,
            'name' => $data['name'] ?? $automatic->name,
            'image' => $this->image->store('programs', $imageFile, 'public', $automatic->image),
            'phrases' => $data['phrases'] ?? $automatic->phrases,
        ]);

        if ($automatic->isDirty()) {
            $automatic->save();
        }

        return $automatic;
    }
}
