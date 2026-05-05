<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        $user = User::where('id', '!=', 1)->inRandomOrder()->first();

        $this->seedAdministrator($admin);
        $this->seedAutoDJ($user);
        $this->seedPrograms($user);
    }

    private function seedAdministrator($user): void
    {
        if(!$user) return;

        Program::factory()
            ->private()
            ->for($user, 'host')
            ->create();
    }

    private function seedPrograms(?User $user): void
    {
       if(!$user) return;

        Program::factory()
            ->free()
            ->for($user, 'host')
            ->create();

        Program::factory()
            ->private()
            ->for($user, 'host')
            ->create();
    }

    private function seedAutoDJ(?User $user): void
    {
        if(!$user) return;

        Program::factory()
            ->automatic()
            ->isDefault()
            ->for($user, 'host')
            ->create();
    }
}
