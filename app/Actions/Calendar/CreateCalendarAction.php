<?php

namespace App\Actions\Administration\Calendar;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Calendar;

class CreateCalendarAction
{
    public function execute(User $user, array $data): Calendar
    {
        $date = $data['date'];

        return Calendar::create([
            'user_id' => $user->id,
            'content' => $data['content'],
            'hour' => $data['hour'],
            'type' => $data['type'],
            'date' => $date,
            'day_of_week' => Carbon::parse($date)->dayOfWeek,
        ]);
    }
}
