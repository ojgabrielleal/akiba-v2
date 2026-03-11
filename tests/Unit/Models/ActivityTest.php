<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Activity model relationships.
     */
    public function testAuthorRelationshipReturnsUser(): void
    {
        $role = \App\Models\Role::factory()->create(['name' => 'administrator']);
        $user = User::factory()->hasAttached($role, [], 'roles')->create();

        $activity = Activity::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($activity->author->is($user));
        $this->assertTrue($activity->author->roles->contains($role));
    }

    public function testConfirmerRelationshipReturnsUsers(): void
    {
        $user = User::factory()->create();
        $confirmers = User::factory(5);

        $activity = Activity::factory()
            ->for($user, 'author')
            ->hasAttached($confirmers, fn() => ['uuid' => (string) \Illuminate\Support\Str::uuid()], 'confirmations')
            ->create();

        $this->assertCount(5, $activity->confirmations);
        $this->assertContainsOnlyInstancesOf(
            User::class,
            $activity->confirmations
        );
    }

    /**
     * Tests from Activity model scopes.
     */
    public function testScopeValidReturnsOnlyValidActivities(): void
    {
        $user = User::factory()->create();

        $expiredActivity = Activity::factory()
            ->for($user, 'author')
            ->create(['limit' => now()->subDays(3)]);

        $validActivity = Activity::factory()
            ->for($user, 'author')
            ->create(['limit' => now()->addDays(3)]);

        $activities = Activity::valid()->get();

        $this->assertTrue($activities->contains($validActivity));
        $this->assertFalse($activities->contains($expiredActivity));
    }
}
