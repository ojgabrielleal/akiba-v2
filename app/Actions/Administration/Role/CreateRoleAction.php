<?php

namespace App\Actions\Administration\Role;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class CreateRoleAction
{
    public function execute(array $data): Role
    {
        $role = Role::create([
            'label' => $data['label'] ?? null,
            'name' => Str::slug($data['label'] ?? ''),
            'weight' => $data['weight'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        if (array_key_exists('permissions', $data)) {
            $permissions = Permission::whereIn('uuid', $data['permissions'])->pluck('id')->toArray();
            $role->permissions()->sync($permissions);
        }

        return $role;
    }
}
