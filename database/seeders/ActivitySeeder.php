<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);

        $this->seedAdministration($admin);
    }

    private function seedAdministration(?User $admin): void
    {
        Activity::factory(5)
            ->for($admin, 'author')
            ->create();
    }
}
