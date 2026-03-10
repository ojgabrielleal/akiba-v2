<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Automatic;
use App\Models\Program;
use App\Models\Onair;

class OnairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autoDefault = Automatic::where('is_default', true)->first();

        if (!$autoDefault) {
            $autoDefault = Automatic::factory()
                ->for(User::find(1) ?? User::factory()->create(), 'host')
                ->create([
                    'is_default' => true,
                ]);
        }

        Onair::factory()
            ->for($autoDefault, 'program')
            ->create([
                'in_air' => true,
                'type' => 'automatic'
            ]);

        $program = Program::factory()
            ->for(User::inRandomOrder()->first(), 'host')
            ->create();

        Onair::factory()->count(5)
            ->for($program, 'program')
            ->create([
                'in_air' => false,
                'type' => 'live'
            ]);

        Onair::factory()->count(5)
            ->for($program, 'program')
            ->create([
                'in_air' => false,
                'type' => 'scheduled'
            ]);
    }
}
