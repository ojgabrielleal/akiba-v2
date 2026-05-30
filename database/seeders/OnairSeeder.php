<?php

namespace Database\Seeders;

use App\Models\Onair;
use App\Models\Program;
use Illuminate\Database\Seeder;

class OnairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auto = Program::where('type', 'automatic')
            ->where('is_auto_dj', true)
            ->first();

        if (!$auto) return;

        Onair::factory()
            ->for($auto, 'program')
            ->withAutoDj()
            ->create(['in_air' => true]);

        $programs = Program::where('type', '!=', 'automatic')
            ->take(2)
            ->get();

        $scheduled = $programs->first();

        if ($scheduled) {
            Onair::factory()
                ->for($scheduled, 'program')
                ->scheduled()
                ->create(['in_air' => false]);
        }

        $playlist = $programs->skip(1)->first() ?? $scheduled;

        if ($playlist) {
            Onair::factory()
                ->for($playlist, 'program')
                ->playlist()
                ->create(['in_air' => false]);
        }
    }
}
