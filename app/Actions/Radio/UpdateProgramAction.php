<?php

namespace App\Actions\Radio;

use App\Models\Program;
use App\Models\User;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdateProgramAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Program $program, array $data, ?UploadedFile $imageFile): Program
    {
        $targetUserId = $program->user_id;
        if (! empty($data['user'])) {
            $user = User::where('uuid', $data['user'])->first();
            if ($user) {
                $targetUserId = $user->id;
            }
        }

        return DB::transaction(function () use ($program, $data, $imageFile, $targetUserId) {
            $program->fill([
                'user_id' => $targetUserId,
                'name' => array_key_exists('name', $data) ? $data['name'] : $program->name,
                'image' => $this->image->store('programs', $imageFile, 'public', $program->image),
                'type' => array_key_exists('type', $data) ? $data['type'] : $program->type,
            ]);

            if ($program->isDirty()) {
                $program->save();
            }

            if (array_key_exists('schedules', $data)) {
                $schedules = collect($data['schedules'] ?? []);

                $uuidsToKeep = $schedules->pluck('uuid')->filter()->toArray();
                $program->schedules()->whereNotIn('uuid', $uuidsToKeep)->delete();

                foreach ($schedules as $schedule) {
                    $payload = [
                        'day' => $schedule['day'],
                        'hour' => $schedule['hour'],
                    ];

                    if (! empty($schedule['uuid'])) {
                        $program->schedules()->updateOrCreate(
                            ['uuid' => $schedule['uuid']],
                            $payload
                        );
                    } else {
                        $program->schedules()->create($payload);
                    }
                }
            }

            return $program;
        });
    }
}
