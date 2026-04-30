<?php

namespace App\Actions\Administration\Role;

use App\Models\Role;
use App\Models\Permission;

class CreateRoleAction
{
    /**
     * @param array{label?: string, weight?: int|null, description?: string|null, permissions?: array<int, string>} $data
     */
    public function execute(array $data): Role
    {
        $role = Role::create([
            'label' => $data['label'] ?? '',
            'weight' => $data['weight'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        if (array_key_exists('permissions', $data)) {
            $permissions = Permission::query()
                ->whereIn('uuid', $data['permissions'])
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissions);
        }

        return $role;
    }
}
