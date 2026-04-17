<?php

namespace App\Actions\Administration\Activity;

use App\Models\Activity;
use Carbon\Carbon;

class CreateActivityAction
{
    public function execute(string $userId, array $data): Activity
    {
        $activity = Activity::create([
            'user_id' => $userId,
            'title' => $data['title'] ?? null,
            'limit' => $data['limit'] ?? null,
            'content' => $data['content'] ?? null,
            'allows_confirmations' => ($data['purpose'] ?? '') === 'activity',
        ]);

        if (($data['purpose'] ?? '') === 'activity') {
            $activity->calendar()->create([
                'user_id' => $userId,
                'has_activity' => true,
                'day_of_week' => Carbon::parse($data['date'] ?? null)->dayOfWeek,
                'hour' => $data['hour'] ?? null,
                'date' => $data['date'] ?? null,
                'content' => $data['title'] ?? null,
                'type' => 'activity',
            ]);
        }

        return $activity;
    }
}
