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
        $admin = User::find(1);
        $user = User::inRandomOrder()->first();

        Program::factory()
            ->automatic()
            ->for($admin ?? $user, 'host')
            ->create([
                'is_default' => true,
                'name' => 'Auto DJ',
            ]);
        
        Program::factory(2)
            ->private()
            ->for($admin, 'host')
            ->has(ProgramSchedule::factory(5), 'schedules')
            ->create();

        Program::factory(2)
            ->private()
            ->for($user, 'host')
            ->has(ProgramSchedule::factory(5), 'schedules')
            ->create();

        Program::factory(2)
            ->free()
            ->for($user, 'host')
            ->create();
    }
}
