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
            'day' => $this->formatDay($this->day),
        ];
    }

    private function formatDay(int $day): string
    {
        $days = [
            0 => "Domingo",
            1 => "Segunda",
            2 => "Terça",
            3 => "Quarta",
            4 => "Quinta",
            5 => "Sexta",
            6 => "Sábado",
        ];

        return $days[$day] ?? "Day not found";
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
