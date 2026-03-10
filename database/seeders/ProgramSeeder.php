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
        Program::factory()->count(2)
            ->for(User::find(1), 'host')
            ->has(ProgramSchedule::factory()->count(2), 'schedules')
            ->create();        

        Program::factory()->count(5)
            ->for(User::inRandomOrder()->first(), 'host')
            ->has(ProgramSchedule::factory()->count(2), 'schedules')
            ->create();
    }
}
