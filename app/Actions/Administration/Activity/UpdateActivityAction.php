<?php

namespace App\Actions\Administration\Activity;

use App\Models\Activity;
use Carbon\Carbon;

class UpdateActivityAction
{
    public function execute(string $userId, Activity $activity, array $data): Activity
    {
        $allowsConfirmations = ($data['purpose'] ?? '') === 'activity' ? filter_var($data['allows_confirmations'] ?? false, FILTER_VALIDATE_BOOLEAN) : false;

        $activity->fill([
            'title' => $data['title'] ?? $activity->title,
            'limit' => $data['limit'] ?? $activity->limit,
            'content' => $data['content'] ?? $activity->content,
            'allows_confirmations' => $allowsConfirmations,
        ]);

        if ($activity->isDirty()) {
            $activity->save();
        }

        if (($data['purpose'] ?? '') === 'activity') {
            $activity->calendar()->updateOrCreate(
                ['activity_id' => $activity->id],
                [
                    'day_of_week' => Carbon::parse($data['date'] ?? null)->dayOfWeek,
                    'hour' => $data['hour'] ?? null,
                    'date' => $data['date'] ?? null,
                    'content' => $data['title'] ?? null,
                    'type' => 'activity',
                    'user_id' => $userId,
                    'has_activity' => true,
                ]
            );
        } else {
            $activity->calendar()->delete();
        }

        return $activity;
    }
}
