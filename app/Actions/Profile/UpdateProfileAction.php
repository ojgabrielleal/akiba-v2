<?php

namespace App\Actions\Profile;

use App\Models\User;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateProfileAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(User $user, array $data, ?UploadedFile $avatarFile): User
    {
        return DB::transaction(function () use ($user, $data, $avatarFile) {
            $user->fill([
                'avatar' => $this->image->store('users', $avatarFile, 'public', $user->avatar),
                'is_auto' => array_key_exists('is_auto', $data) ? $data['is_auto'] : $user->is_auto,
                'name' => array_key_exists('name', $data) ? $data['name'] : $user->name,
                'nickname' => array_key_exists('nickname', $data) ? $data['nickname'] : $user->nickname,
                'gender' => array_key_exists('gender', $data) ? $data['gender'] : $user->gender,
                'birthday' => array_key_exists('birthday', $data) ? $data['birthday'] : $user->birthday,
                'city' => array_key_exists('city', $data) ? $data['city'] : $user->city,
                'state' => array_key_exists('state', $data) ? $data['state'] : $user->state,
                'country' => array_key_exists('country', $data) ? $data['country'] : $user->country,
                'bibliography' => array_key_exists('bibliography', $data) ? $data['bibliography'] : $user->bibliography,
            ]);

            if ($user->isDirty()) {
                $user->save();
            }

            if (! empty($data['socials'])) {
                foreach ($data['socials'] as $social) {
                    if (empty($social['uuid'])) {
                        continue;
                    }

                    $user->socials()->where('uuid', $social['uuid'])->update([
                        'name' => $social['name'],
                        'url' => $social['url'],
                    ]);
                }
            }

            if (! empty($data['preferences'])) {
                $preferences = $data['preferences'];
                $likes = $preferences['likes'] ?? [];
                $unlikes = $preferences['unlikes'] ?? [];

                foreach (collect($likes)->merge($unlikes) as $preference) {
                    if (empty($preference['uuid'])) {
                        continue;
                    }

                    $user->preferences()->where('uuid', $preference['uuid'])->update([
                        'content' => $preference['content'],
                    ]);
                }
            }

            if (! empty($data['favorites'])) {
                foreach ($data['favorites'] as $favorite) {
                    if (empty($favorite['uuid'])) {
                        continue;
                    }

                    $user->favorites()->where('uuid', $favorite['uuid'])->update([
                        'name' => $favorite['name'],
                        'image' => $favorite['image'],
                    ]);
                }
            }

            return $user;
        });
    }
}
