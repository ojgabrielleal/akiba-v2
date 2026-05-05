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

        $this->seedAdministration($admin, $user);
        $this->seedNonAdministrationContent($user);
    }

    private function seedAdministration(?User $admin, ?User $user): void
    {
        $host = $admin ?? $user;

        Program::updateOrCreate(
            ['name' => 'Auto DJ'],
            Program::factory()
                ->automatic()
                ->make([
                    'user_id' => $host?->id,
                    'is_default' => true,
                    'name' => 'Auto DJ',
                ])
                ->toArray()
        );

        Program::factory(2)
            ->private()
            ->for($admin, 'host')
            ->has(ProgramSchedule::factory(5), 'schedules')
            ->create();
    }

    private function seedNonAdministrationContent(?User $user): void
    {
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
