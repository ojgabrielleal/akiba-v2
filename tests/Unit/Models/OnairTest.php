<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;

class OnairTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Onair model relationships.
     */
    public function testProgramRelationship(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $onair = Onair::factory()
            ->for($program, 'program')
            ->create();

        $this->assertTrue($onair->program->is($program));
    }

    /**
     * Tests from Onair model scopes.
     */
    public function testLiveScope(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $liveOnair = Onair::factory()
            ->for($program, 'program')
            ->create([
                'in_air' => true,
            ]);

        $notLiveOnair = Onair::factory()
            ->for($program, 'program')
            ->create([
                'in_air' => false,
            ]);

        $onairs = Onair::live()->get();

        $this->assertTrue($onairs->contains($liveOnair));
        $this->assertFalse($onairs->contains($notLiveOnair));
    }
}
