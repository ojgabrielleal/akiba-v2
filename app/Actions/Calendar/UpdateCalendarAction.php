<?php

namespace App\Actions\Administration\Calendar;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Calendar;

class UpdateCalendarAction
{
    public function execute(Calendar $calendar, User $user, array $data): Calendar
    {
        $date = $data['date'] ?? null;

        $calendar->fill([
            'user_id' => $user->id,
            'content' => $data['content'],
            'hour' => $data['hour'],
            'type' => $data['type'],
            'date' => $date,
            'day_of_week' => Carbon::parse($date)->dayOfWeek,
        ]);

        if ($calendar->isDirty()) {
            $calendar->save();
        }

        return $calendar;
    }
}
