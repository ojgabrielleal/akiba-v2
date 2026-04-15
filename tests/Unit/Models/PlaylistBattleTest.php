<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\PlaylistBattle;

class PlaylistBattleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from PlaylistBattle model attributes.
     */
    public function testDayCast(): void
    {
        $playlist = PlaylistBattle::factory()->create(['day' => 3]);

        $this->assertIsInt($playlist->day);
        $this->assertEquals(3, $playlist->day);
    }
}
