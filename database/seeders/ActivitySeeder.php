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
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'administrator');
        })->first();

        Activity::factory()->count(15)
            ->for($admin, 'author')
            ->create();
    }
}
