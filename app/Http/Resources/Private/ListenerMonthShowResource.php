<?php

namespace App\Http\Resources\Private;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListenerMonthShowResource extends JsonResource
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
            'avatar' => $this->avatar,
            'name' => $this->name,
            'address' => $this->address,
            'favorite_program' => $this->favorite_program,
            'requests_total' => $this->requests_total,
        ];
    }
}
