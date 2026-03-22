<?php

namespace App\Http\Resources\Private;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollIndexResource extends JsonResource
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
            'question' => $this->question,
            'options' => $this->options->map(fn($item)=>[
                'uuid' => $item->uuid,
                'option' => $item->option, 
                'votes' => $item->votes,
            ])
        ];
    }
}
