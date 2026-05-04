<?php

namespace App\Actions\Radio;

use Illuminate\Support\Facades\DB;
use App\Services\Process\ImageProcessService;

use App\Models\User;
use App\Models\Program;

class UpdateProgramAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Program $program, User $user, array $data): Program
    {
        return DB::transaction(function () use ($program, $user, $data) {
            $program->fill([
                'user_id' => $user->id,
                'name' => $data['name'],
                'image' => $this->image->store('programs', $data['image'], 'public', $program->image),
                'type' => $data['type'],
            ]);

            if ($program->isDirty()){
                $program->save();
            }

            if (!empty($data['schedules'])){
                $uuids = $data['schedules']->pluck('uuid')->filter()->toArray();
                $program->schedules()->whereNotIn('uuid', $uuids)->delete();

                foreach ($data['schedules'] as $schedule) {
                    $program->schedules()->updateOrCreate(
                        ['uuid' => $schedule['uuid']],
                        [
                            'day' => $schedule['day'], 
                            'hour' => $schedule['hour']
                        ]
                    );
                }
            }

            return $program;
        });
    }
}
