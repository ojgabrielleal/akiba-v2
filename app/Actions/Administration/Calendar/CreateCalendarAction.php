<?php

namespace App\Actions\Administration\Calendar;

use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;

class CreateCalendarAction
{
    public function execute(array $data): Calendar
    {
        $user = User::where('uuid', $data['user'] ?? '')->first();
        $date = $data['date'] ?? null;

        return Calendar::create([
            'user_id' => $user ? $user->id : null,
            'content' => $data['content'] ?? null,
            'day_of_week' => $date ? Carbon::parse($date)->dayOfWeek : null,
            'date' => $date,
            'hour' => $data['hour'] ?? null,
            'type' => $data['type'] ?? null,
        ]);
    }
}
