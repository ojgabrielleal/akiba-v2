<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::inRandomOrder()->first();
        $admin = User::find(1);

        Task::factory(5)
            ->for($user, 'responsible')
            ->create();

        Task::factory(5)
            ->for($admin, 'responsible')
            ->create();

        Task::factory(5)
            ->for($admin, 'responsible')
            ->create([
                'dead_line' => fn() => fake()->dateTimeBetween(
                    now()->startOfWeek(), now()->endOfWeek()
                )->format('Y-m-d')
            ]);
    }
}
