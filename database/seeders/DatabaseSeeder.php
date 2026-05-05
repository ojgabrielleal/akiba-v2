<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ActivitySeeder::class,
            ProgramSeeder::class,
            OnairSeeder::class,
        ]);

        if (app()->environment('local')) {
            $this->fake();
            $this->development();
        }
    }

    private function fake(): void
    {
        $this->call([
            EventSeeder::class,
            ListenerMonthSeeder::class,
            MusicSeeder::class,
            PlaylistBattleSeeder::class,
            PollSeeder::class,
            PostSeeder::class,
            PodcastSeeder::class,
            RepositorySeeder::class,
            ReviewSeeder::class,
            TaskSeeder::class,
        ]);
    }

    private function development(): void
    {
        $this->call([
            CalendarSeeder::class,
            ProgramSeeder::class,
            OnairSeeder::class,
            SongRequestSeeder::class,
        ]);
    }
}
