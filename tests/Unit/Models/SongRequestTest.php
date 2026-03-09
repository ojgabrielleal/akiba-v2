<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\SongRequest;
use App\Models\Onair;
use App\Models\Music;
use App\Models\User;
use App\Models\Program;

class SongRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from SongRequest model relationships.
     */
    public function testOnairRelationshipReturnsOnair(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create(['user_id' => $user->id]);
        $onair = Onair::factory()->create([
            'program_id' => $program->id,
            'program_type' => get_class($program)
        ]);

        $music = Music::factory()->create();

        $songRequest = SongRequest::factory()
            ->for($onair, 'onair')
            ->create(['music_id' => $music->id]);

        $this->assertInstanceOf(Onair::class, $songRequest->onair);
        $this->assertTrue($songRequest->onair->is($onair));
    }

    public function testMusicRelationshipReturnsMusic(): void
    {
        $music = Music::factory()->create();

        $user = User::factory()->create();
        $program = Program::factory()->create(['user_id' => $user->id]);
        $onair = Onair::factory()->create([
            'program_id' => $program->id,
            'program_type' => get_class($program)
        ]);

        $songRequest = SongRequest::factory()
            ->for($music, 'music')
            ->create(['onair_id' => $onair->id]);

        $this->assertInstanceOf(Music::class, $songRequest->music);
        $this->assertTrue($songRequest->music->is($music));
    }
}
