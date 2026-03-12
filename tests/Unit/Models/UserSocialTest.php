<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserSocial;

class UserSocialTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from UserSocial model relationships.
     */
    public function testUserRelationship(): void
    {
        $user = User::factory()->create();

        $social = UserSocial::factory()
            ->for($user, 'user')
            ->create();

        $this->assertInstanceOf(User::class, $social->user);
        $this->assertTrue($social->user->is($user));
    }
}
