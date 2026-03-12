<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Podcast;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        $user = User::inRandomOrder()->first();
        
        Podcast::factory(5)
            ->for($admin, 'author')
            ->create();

        Podcast::factory(5)
            ->for($user, 'author')
            ->create();
    }
}
