<?php

namespace App\Actions\Administration\Calendar;

use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;

class UpdateCalendarAction
{
    public function execute(Calendar $calendar, array $data): Calendar
    {
        $user = User::where('uuid', $data['user'] ?? '')->first();
        $date = $data['date'] ?? null;

        $calendar->fill([
            'user_id' => $user ? $user->id : $calendar->user_id,
            'content' => array_key_exists('content', $data) ? $data['content'] : $calendar->content,
            'day_of_week' => $date ? Carbon::parse($date)->dayOfWeek : $calendar->day_of_week,
            'date' => array_key_exists('date', $data) ? $date : $calendar->date,
            'hour' => array_key_exists('hour', $data) ? $data['hour'] : $calendar->hour,
            'type' => array_key_exists('type', $data) ? $data['type'] : $calendar->type,
        ]);

        if ($calendar->isDirty()) {
            $calendar->save();
        }

        return $calendar;
    }
}
