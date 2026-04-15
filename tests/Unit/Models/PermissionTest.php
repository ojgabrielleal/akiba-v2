<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Permission;
use App\Models\Role;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Permission model relationships.
     */
    public function testRolesRelationship(): void
    {
        $permission = Permission::factory()->create();

        $role = Role::factory()
            ->hasAttached($permission, [], 'permissions')
            ->create();

        $this->assertCount(1, $permission->roles);
        $this->assertContainsOnlyInstancesOf(Role::class, $permission->roles);
    }
}
