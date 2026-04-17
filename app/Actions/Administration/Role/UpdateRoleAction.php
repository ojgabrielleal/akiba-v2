<?php

namespace App\Actions\Administration\Role;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class UpdateRoleAction
{
    public function execute(Role $role, array $data): Role
    {
        $role->fill([
            'label' => $data['label'] ?? $role->label,
            'name' => isset($data['label']) ? Str::slug($data['label']) : $role->name,
            'weight' => $data['weight'] ?? $role->weight,
            'description' => $data['description'] ?? $role->description,
        ]);

        if ($role->isDirty()) {
            $role->save();
        }

        if (array_key_exists('permissions', $data)) {
            $permissions = Permission::whereIn('uuid', $data['permissions'])->pluck('id')->toArray();
            $role->permissions()->sync($permissions);
        }

        return $role;
    }
}
