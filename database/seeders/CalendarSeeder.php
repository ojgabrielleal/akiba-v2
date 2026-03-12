<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Activity;
use App\Models\Calendar;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        $user = User::inRandomOrder()->first();
        
        Activity::factory()
            ->for($admin, 'author')
            ->create([
                'allows_confirmations' => true,
            ]);

        Calendar::factory(5)
            ->for($user, 'responsible')
            ->create();

        Calendar::factory(5)
            ->for($user, 'responsible')
            ->create();
        
        $confirmations = Activity::where('allows_confirmations', true)->get();
        foreach ($confirmations as $confirmation) {
            Calendar::factory()
                ->for($user, 'responsible')
                ->for($confirmation, 'activity')
                ->create([
                    'has_activity' => true,
                ]);
        }
    }
}
