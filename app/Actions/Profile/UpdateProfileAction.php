<?php

namespace App\Actions\Profile;

use App\Models\User;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class UpdateProfileAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(User $user, array $data, ?UploadedFile $avatarFile): User
    {
        $user->fill([
            'avatar' => $this->image->store('users', $avatarFile, 'public', $user->avatar),
            'is_auto' => $data['is_auto'] ?? $user->is_auto,
            'name' => $data['name'] ?? $user->name,
            'nickname' => $data['nickname'] ?? $user->nickname,
            'gender' => $data['gender'] ?? $user->gender,
            'birthday' => $data['birthday'] ?? $user->birthday,
            'city' => $data['city'] ?? $user->city,
            'state' => $data['state'] ?? $user->state,
            'country' => $data['country'] ?? $user->country,
            'bibliography' => $data['bibliography'] ?? $user->bibliography,
        ]);

        if ($user->isDirty()) {
            $user->save();
        }

        if (!empty($data['socials'])) {
            foreach ($data['socials'] as $social) {
                $user->socials()->where('uuid', $social['uuid'])->update([
                    'name' => $social['name'],
                    'url' => $social['url'],
                ]);
            }
        }

        if (!empty($data['preferences'])) {
            $preferences = $data['preferences'];

            foreach (collect($preferences['likes'])->merge($preferences['unlikes']) as $preference) {
                $user->preferences()->where('uuid', $preference['uuid'])->update([
                    'content' => $preference['content'],
                ]);
            }
        }

        return $user;
    }
}
