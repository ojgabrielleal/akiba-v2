<?php

namespace App\Actions\Radio;

use App\Models\Program;
use App\Models\User;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateProgramAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(User $currentUser, array $data, ?UploadedFile $imageFile): Program
    {
        $targetUserId = $currentUser->id;

        if (($data['type'] ?? '') === 'private' && ! empty($data['user'])) {
            $user = User::where('uuid', $data['user'])->first();
            if ($user) {
                $targetUserId = $user->id;
            }
        }

        return DB::transaction(function () use ($targetUserId, $data, $imageFile) {
            $program = Program::create([
                'user_id' => $targetUserId,
                'name' => $data['name'] ?? null,
                'description' => $data['description'] ?? null,
                'image' => $this->image->store('programs', $imageFile, 'public'),
                'type' => $data['type'] ?? null,
            ]);

            if (($data['type'] ?? '') === 'private' && ! empty($data['schedules'])) {
                foreach ($data['schedules'] as $schedule) {
                    $program->schedules()->create([
                        'day' => $schedule['day'],
                        'hour' => $schedule['hour'],
                    ]);
                }
            }

            return $program;
        });
    }
}
