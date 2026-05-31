<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\HasFormats;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OnairResource extends JsonResource
{
    use HasFormats;

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
            'start_at' => $this->start_at?->setTimezone('America/Sao_Paulo')->format('H\hi - d/m'),
            'finish_at' => $this->finish_at?->setTimezone('America/Sao_Paulo')->format('H\hi - d/m'),
            'allows_song_requests' => $this->allows_song_requests,
            'song_requests_total' => $this->song_requests_total,
            'program' => ProgramResource::make($this->program),
            'created_at' => $this->created_at->setTimezone('America/Sao_Paulo')->format('d/m/Y - H:i'),
        ];
    }

    public static function toCollectionArray(Collection $collection, Request $request, ?string $format): ?array
    {
        if ($format !== 'grouped_by_type') {
            return null;
        }

        return [
            'scheduled' => self::resolveTypeCollection($collection, $request, 'scheduled'),
            'playlist' => self::resolveTypeCollection($collection, $request, 'playlist'),
        ];
    }

    private static function resolveTypeCollection(Collection $collection, Request $request, string $type): array
    {
        return $collection
            ->filter(fn ($item) => $item->type === $type)
            ->values()
            ->map(fn ($item) => self::make($item->resource ?? $item)->resolve($request))
            ->all();
    }
}
