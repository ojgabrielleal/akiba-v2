<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Airtime;
use App\Models\Program;
use App\Models\User;

class AirtimeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Airtime model relationships.
     */
    public function testProgramRelationship(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $schedule = Airtime::factory()
            ->for($program, 'program')
            ->create();

        $this->assertTrue($schedule->program->is($program));
    }
}
