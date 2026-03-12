<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;
use App\Models\Music;
use App\Models\SongRequest;

class SongRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $onairs = Onair::inRandomOrder()->take(5)->get();
        $music = Music::inRandomOrder()->first();

        if ($onairs->isEmpty()) {
            return;
        }

        foreach ($onairs as $onair) {
            SongRequest::factory(5)
                ->for($onair, 'onair')
                ->for($music, 'music')
                ->create();
        }
    }
}
