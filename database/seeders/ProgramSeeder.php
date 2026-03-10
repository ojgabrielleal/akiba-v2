<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Program;
use App\Models\ProgramSchedule;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Private programs with schedules
        Program::factory()->count(2)
            ->state(['type' => 'private'])
            ->for(User::find(1), 'host')
            ->has(ProgramSchedule::factory()->count(2), 'schedules')
            ->create();

        Program::factory()->count(3)
            ->state(['type' => 'private'])
            ->for(User::inRandomOrder()->first(), 'host')
            ->has(ProgramSchedule::factory()->count(2), 'schedules')
            ->create();

        // Free programs without schedules
        Program::factory()->count(4)
            ->state(['type' => 'free'])
            ->for(User::inRandomOrder()->first(), 'host')
            ->create();
    }
}
