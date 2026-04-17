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

        return Calendar::create([
            'user_id' => $user ? $user->id : null,
            'content' => $data['content'] ?? null,
            'day_of_week' => Carbon::parse($data['date'] ?? null)->dayOfWeek,
            'date' => $data['date'] ?? null,
            'hour' => $data['hour'] ?? null,
            'type' => $data['type'] ?? null,
        ]);
    }
}
