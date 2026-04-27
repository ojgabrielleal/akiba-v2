<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserFavorite;

class UserFavoriteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from UserFavorite model relationships.
     */
    public function testUserRelationship(): void
    {
        $user = User::factory()->create();

        $favorite = UserFavorite::factory()
            ->for($user, 'user')
            ->create();

        $this->assertTrue($favorite->user->is($user));
    }
}
