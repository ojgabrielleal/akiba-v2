<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\ActivityParticipants;
use App\Models\User;
use App\Models\Activity;

class ActivityParticipantsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from ActivityParticipants model relationships.
     */
    public function testConfirmerRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $activity = Activity::factory()->create(['user_id' => $user->id]);

        $participant = ActivityParticipants::factory()
            ->for($user, 'confirmer')
            ->create(['activity_id' => $activity->id]);

        $this->assertInstanceOf(User::class, $participant->confirmer);
        $this->assertTrue($participant->confirmer->is($user));
    }
}
