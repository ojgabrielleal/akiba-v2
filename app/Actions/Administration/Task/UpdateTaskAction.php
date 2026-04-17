<?php

namespace App\Actions\Administration\Task;

use App\Models\Task;
use App\Models\User;

class UpdateTaskAction
{
    public function execute(Task $task, array $data): Task
    {
        $user = User::where('uuid', $data['user'] ?? '')->first();

        $task->fill([
            'user_id' => $user ? $user->id : $task->user_id,
            'title' => $data['title'] ?? $task->title,
            'dead_line' => $data['dead_line'] ?? $task->dead_line,
            'content' => $data['content'] ?? $task->content,
        ]);

        if ($task->isDirty()) {
            $task->save();
        }

        return $task;
    }
}
