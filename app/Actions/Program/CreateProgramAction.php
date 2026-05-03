<?php

namespace App\Actions\Radio;

use Illuminate\Support\Facades\DB;
use App\Services\Process\ImageProcessService;

use App\Models\User;
use App\Models\Program;

class CreateProgramAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(User $user, array $data): Program
    {
        return DB::transaction(function () use ($user, $data) {
            $program = Program::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'image' => $this->image->store('programs', $data['image'], 'public'),
                'type' => $data['type'],
            ]);

            if ($data['type'] === 'private' && !empty($data['schedules'])) {
                $program->schedules()->createMany($data['schedules']);
            }

            return $program;
        });
    }
}
