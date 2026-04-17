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

        $calendar->fill([
            'user_id' => $user ? $user->id : $calendar->user_id,
            'content' => $data['content'] ?? $calendar->content,
            'day_of_week' => Carbon::parse($data['date'] ?? null)->dayOfWeek,
            'date' => $data['date'] ?? $calendar->date,
            'hour' => $data['hour'] ?? $calendar->hour,
            'type' => $data['type'] ?? $calendar->type,
        ]);

        if ($calendar->isDirty()) {
            $calendar->save();
        }

        return $calendar;
    }
}
