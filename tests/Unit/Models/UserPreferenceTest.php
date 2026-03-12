<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserPreference;

class UserPreferenceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from UserPreference model relationships.
     */
    public function testUserRelationship(): void
    {
        $user = User::factory()->create();

        $preference = UserPreference::factory()
            ->for($user, 'user')
            ->create();

        $this->assertTrue($preference->user->is($user));
    }
}
