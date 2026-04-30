<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ListenerMonth;

class ListenerMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedNonAdministrationContent();
    }

    private function seedNonAdministrationContent(): void
    {
        ListenerMonth::factory(5)->create();
    }
}
