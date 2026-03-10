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
        Podcast::factory()->count(3)
            ->for(User::find(1), 'author')
            ->create();

        Podcast::factory()->count(7)
            ->for(User::inRandomOrder()->first(), 'author')
            ->create();
    }
}
