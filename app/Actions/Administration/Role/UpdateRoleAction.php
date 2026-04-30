<?php

namespace App\Actions\Administration\Role;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdateRoleAction
{
    /**
     * @param  array{label?: string, weight?: int|null, description?: string|null, permissions?: array<int, string>}  $data
     */
    public function execute(Role $role, array $data): Role
    {
        return DB::transaction(function () use ($role, $data) {
            $role->fill([
                'label' => array_key_exists('label', $data) ? $data['label'] : $role->label,
                'weight' => array_key_exists('weight', $data) ? $data['weight'] : $role->weight,
                'description' => array_key_exists('description', $data) ? $data['description'] : $role->description,
            ]);

            if ($role->isDirty()) {
                $role->save();
            }

            if (array_key_exists('permissions', $data)) {
                $permissions = Permission::query()
                    ->whereIn('uuid', $data['permissions'])
                    ->pluck('id')
                    ->toArray();

                $role->permissions()->sync($permissions);
            }

            return $role;
        });
    }
}
