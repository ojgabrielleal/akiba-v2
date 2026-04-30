<?php

namespace App\Actions\Administration\Activity;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateActivityAction
{
    public function execute(string $userId, array $data): Activity
    {
        return DB::transaction(function () use ($userId, $data) {
            $activity = Activity::create([
                'user_id' => $userId,
                'title' => $data['title'] ?? null,
                'limit' => $data['limit'] ?? null,
                'content' => $data['content'] ?? null,
                'allows_confirmations' => ($data['purpose'] ?? '') === 'activity',
            ]);

            if (($data['purpose'] ?? '') === 'activity') {
                $date = $data['date'] ?? null;

                $activity->calendar()->create([
                    'user_id' => $userId,
                    'has_activity' => true,
                    'day_of_week' => $date ? Carbon::parse($date)->dayOfWeek : null,
                    'hour' => $data['hour'] ?? null,
                    'date' => $date,
                    'content' => $data['title'] ?? null,
                    'type' => 'activity',
                ]);
            }

            return $activity;
        });
    }
}
