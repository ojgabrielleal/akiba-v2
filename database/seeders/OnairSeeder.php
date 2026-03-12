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
        $admin = User::find(1);
        $user = User::inRandomOrder()->first();

        $auto = Automatic::where('is_default', true)->first();

        if (!$auto) {
            $auto = Automatic::factory()
                ->for($admin ?? $user, 'host')
                ->create([
                    'is_default' => true,
                ]);
        }

        Onair::factory()
            ->for($auto, 'program')
            ->create([
                'type' => 'automatic'
            ]);

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        Onair::factory(5)
            ->for($program, 'program')
            ->create([
                'in_air' => false,
                'type' => 'live'
            ]);
    }
}
