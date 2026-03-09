<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\ProgramSchedule;
use App\Models\Program;
use App\Models\User;

class ProgramScheduleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from ProgramSchedule model relationships.
     */
    public function testProgramRelationshipReturnsProgram(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->create(['user_id' => $user->id]);

        $schedule = ProgramSchedule::factory()
            ->for($program, 'program')
            ->create();

        $this->assertInstanceOf(Program::class, $schedule->program);
        $this->assertTrue($schedule->program->is($program));
    }
}
