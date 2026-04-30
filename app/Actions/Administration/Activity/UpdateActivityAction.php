<?php

namespace App\Actions\Administration\Activity;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateActivityAction
{
    public function execute(string $userId, Activity $activity, array $data): Activity
    {
        return DB::transaction(function () use ($userId, $activity, $data) {
            $allowsConfirmations = ($data['purpose'] ?? '') === 'activity';

            $activity->fill([
                'title' => array_key_exists('title', $data) ? $data['title'] : $activity->title,
                'limit' => array_key_exists('limit', $data) ? $data['limit'] : $activity->limit,
                'content' => array_key_exists('content', $data) ? $data['content'] : $activity->content,
                'allows_confirmations' => $allowsConfirmations,
            ]);

            if ($activity->isDirty()) {
                $activity->save();
            }

            if (($data['purpose'] ?? '') === 'activity') {
                $date = $data['date'] ?? null;

                $activity->calendar()->updateOrCreate(
                    ['activity_id' => $activity->id],
                    [
                        'day_of_week' => $date ? Carbon::parse($date)->dayOfWeek : $activity->calendar?->day_of_week,
                        'hour' => array_key_exists('hour', $data) ? $data['hour'] : $activity->calendar?->hour,
                        'date' => array_key_exists('date', $data) ? $date : $activity->calendar?->date,
                        'content' => array_key_exists('title', $data) ? $data['title'] : $activity->calendar?->content,
                        'type' => 'activity',
                        'user_id' => $userId,
                        'has_activity' => true,
                    ]
                );
            } else {
                $activity->calendar()->delete();
            }

            return $activity;
        });
    }
}
