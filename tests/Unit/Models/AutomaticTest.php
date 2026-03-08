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
    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();
        $auto = Automatic::factory()
            ->for($user, 'host')
            ->create();

        $this->assertTrue($auto->host->is($user));
    }

    public function testOnairRelationshipReturnsOnair(): void
    {
        $user = User::factory()->create();

        $auto = Automatic::factory()
            ->for($user, 'host')
            ->create();

        $onair = Onair::factory()
            ->for($auto, 'program')
            ->create();

        $this->assertTrue($auto->onair->contains($onair));
    }
}
