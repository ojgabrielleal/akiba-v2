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
            'title' => array_key_exists('title', $data) ? $data['title'] : $task->title,
            'dead_line' => array_key_exists('dead_line', $data) ? $data['dead_line'] : $task->dead_line,
            'content' => array_key_exists('content', $data) ? $data['content'] : $task->content,
        ]);

        if ($task->isDirty()) {
            $task->save();
        }

        return $task;
    }
}
