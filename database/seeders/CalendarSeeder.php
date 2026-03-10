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
        Calendar::factory()->count(5)
            ->for(User::inRandomOrder()->first(), 'responsible')
            ->create();

        Calendar::factory()->count(10)
            ->for(User::find(1), 'responsible')
            ->create();

        Activity::factory()
            ->for(User::find(1), 'author')
            ->create([
                'allows_confirmations' => true,
            ]);
        
        $confirmations = Activity::where('allows_confirmations', true)->get();

        foreach ($confirmations as $confirmation) {
            Calendar::factory()
                ->for(User::inRandomOrder()->first(), 'responsible')
                ->for($confirmation, 'activity')
                ->create([
                    'has_activity' => true,
                ]);
        }
    }
}
