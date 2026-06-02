<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('is_virtual', false)->first() ?? User::first();

        if (!$user) return;

        Program::active()
            ->where('execution_mode', '!=', 'playlist')
            ->get()
            ->each(function (Program $program, int $index) use ($user) {
                $startAt = now()
                    ->addDays($index + 1)
                    ->setTime(14, 0);

                $start = Plan::factory()
                    ->for($user)
                    ->for($program, 'plannable')
                    ->create([
                        'action' => 'start_program',
                        'scheduled_at' => $startAt,
                        'status' => 'pending',
                    ]);

                Plan::factory()
                    ->finishProgram()
                    ->for($user)
                    ->for($program, 'plannable')
                    ->create([
                        'root_id' => $start->id,
                        'scheduled_at' => $startAt->copy()->addHours(2),
                        'status' => 'pending',
                    ]);
            });
    }
}
