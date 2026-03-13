<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProgramIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'image' => $this->image,
            'type' => $this->type,
            'host' => [
                'uuid' => $this->host->uuid,
                'name' => $this->host->name,
                'nickname' => $this->host->nickname,
                'avatar' => $this->host->avatar,
                'gender' => $this->host->gender,
            ],
            'schedules' => $this->schedules->map(function ($schedule) {
                return [
                    'uuid' => $schedule->uuid,
                    'day' => $schedule->day,
                    'hour' => $this->formatHour($schedule->hour),
                ];
            })
        ];
    }

    private function formatHour($datetime)
    {
        $hour = Carbon::parse($datetime)->hour;

        $period = match (true) {
            $hour < 12 => 'da manhã',
            $hour < 18 => 'da tarde',
            default => 'da noite',
        };

        return Carbon::parse($datetime)->format('g') . ' ' . $period;
    }
}
