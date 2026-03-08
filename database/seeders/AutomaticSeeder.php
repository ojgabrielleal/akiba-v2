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
        Automatic::factory()
            ->for(User::factory()->create(), 'host')
            ->create([
                'is_default' => true,
            ]);
    }
}
