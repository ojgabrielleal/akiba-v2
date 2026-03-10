<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory()->count(3)
            ->for(User::find(1), 'author')
            ->create();

        Event::factory()->count(5)
            ->for(User::inRandomOrder()->first(), 'author')
            ->create();
    }
}
