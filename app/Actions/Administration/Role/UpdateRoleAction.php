<?php

namespace App\Actions\Administration\Role;

use App\Models\Role;
use App\Models\Permission;

class UpdateRoleAction
{
    /**
     * @param array{label?: string, weight?: int|null, description?: string|null, permissions?: array<int, string>} $data
     */
    public function execute(Role $role, array $data): Role
    {
        $role->fill([
            'label' => $data['label'] ?? $role->label,
            'weight' => $data['weight'] ?? $role->weight,
            'description' => $data['description'] ?? $role->description,
        ]);

        if ($role->isDirty()) {
            $role->save();
        }

        if (array_key_exists('permissions', $data)) {
            $permissions = Permission::query()
                ->whereIn('uuid', $data['permissions'], 'and', false)
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissions);
        }

        return $role;
    }
}
