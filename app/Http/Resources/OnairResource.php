<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnairResource extends JsonResource
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
            'phrase' => $this->phrase,
            'type' => $this->type,
            'start_at' => $this->start_at?->setTimezone('America/Sao_Paulo')->format('d/m/Y - H:i'),
            'finish_at' => $this->finish_at?->setTimezone('America/Sao_Paulo')->format('d/m/Y - H:i'),
            'allows_song_requests' => $this->allows_song_requests,
            'song_requests_total' => $this->song_requests_total,
            'program' => ProgramResource::make($this->program),
            'created_at' => $this->created_at->setTimezone('America/Sao_Paulo')->format('d/m/Y - H:i'),
        ];  
    }
}
