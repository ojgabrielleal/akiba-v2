<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from User model scopes.
     */
    public function testActiveScope(): void
    {
        $activeUser = User::factory()
            ->create([
                'is_active' => true
            ]);

        $inactiveUser = User::factory()
            ->create([
                'is_active' => false
            ]);

        $users = User::active()->get();

        $this->assertTrue($users->contains($activeUser));
        $this->assertFalse($users->contains($inactiveUser));
    }

    /**
     * Tests from User model attributes.
     */
    public function testSlugAttribute(): void
    {
        $user = User::factory()->create(
            ['nickname' => 'sample-review-title']
        );

        $this->assertEquals('sample-review-title', $user->slug);
    }

    public function testPasswordAttributeAcceptsNullableValues(): void
    {
        $user = User::factory()->create([
            'username' => null,
            'password' => null,
        ]);

        $this->assertNull($user->username);
        $this->assertNull($user->password);
    }

    public function testPasswordAttributeIgnoresEmptyValues(): void
    {
        $user = User::factory()->create([
            'username' => null,
            'password' => '',
        ]);

        $this->assertNull($user->password);
    }

    public function testPasswordAttributeHashesFilledValues(): void
    {
        $user = User::factory()->create([
            'password' => 'secret',
        ]);

        $this->assertTrue(Hash::check('secret', $user->password));
    }
}
