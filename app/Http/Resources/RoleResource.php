<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'label' => $this->label, 
            'name' => $this->name, 
            'description' => $this->description,
            'weight' => $this->weight,
            'permissions' => $this->permissions->map(fn($item) => [
                'uuid' => $item->uuid,
                'label' => $item->label,
                'name' => $item->name,
            ])
        ];
    }
}
