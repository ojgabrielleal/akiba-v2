<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Onair;
use App\Models\Automatic;

class AutomaticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Automatic model relationships.
     */
    public function testAuthorRelationship(): void
    {
        $user = User::factory()->create();

        $auto = Automatic::factory()
            ->for($user, 'host')
            ->create();

        $this->assertTrue($auto->host->is($user));
    }

    public function testOnairRelationship(): void
    {
        $user = User::factory()->create();

        $auto = Automatic::factory()
            ->for($user, 'host')
            ->create();

        $onair = Onair::factory()
            ->for($auto, 'program')
            ->create();

        $this->assertContainsOnlyInstancesOf(Onair::class, $auto->onair);
    }

    /**
     * Tests from Automatic model scopes.
     */
    public function testActiveScope(): void
    {
        $user = User::factory()->create();

        $activeAuto = Automatic::factory()
            ->for($user, 'host')
            ->create(['is_active' => true]);

        $inactiveAuto = Automatic::factory()
            ->for($user, 'host')
            ->create(['is_active' => false]);

        $actives = Automatic::active()->get();

        $this->assertTrue($actives->contains($activeAuto));
        $this->assertFalse($actives->contains($inactiveAuto));
    }

}
