<?php

namespace App\Actions\Administration\Task;

use App\Models\Task;
use App\Models\User;

class CreateTaskAction
{
    public function execute(array $data): Task
    {
        $user = User::where('uuid', $data['user'] ?? '')->first();

        return Task::create([
            'user_id' => $user ? $user->id : null,
            'title' => $data['title'] ?? null,
            'content' => $data['content'] ?? null,
            'dead_line' => $data['dead_line'] ?? null,
        ]);
    }
}
