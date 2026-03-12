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
        $admin = User::find(1);
        $user = User::inRandomOrder()->first();
        
        Event::factory(5)
            ->for($admin, 'author')
            ->create();

        Event::factory(5)
            ->for($user, 'author')
            ->create();
    }
}
