<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AirtimeResource extends JsonResource
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
            'hour' => $this->formatHour($this->hour),
            'day' => $this->day,
        ];
    }

    private function formatHour($datetime): string
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
