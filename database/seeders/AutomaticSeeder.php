<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Automatic;

class AutomaticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::inRandomOrder()->first();
        
        Automatic::factory()
            ->for($user, 'host')
            ->create([
                'is_default' => true,
            ]);

        Automatic::factory(5)
            ->for($user, 'host')
            ->create();
    }
}
