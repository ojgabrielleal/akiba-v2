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
            ->where('is_default', true)
            ->first();

        if (!$auto) return;

        Onair::firstOrCreate(
            [
                'program_id' => $auto->id,
                'type' => 'automatic',
            ],
            Onair::factory()
                ->for($auto, 'program')
                ->automatic()
                ->make(['in_air' => true])
                ->getAttributes()
        );
    }
}
