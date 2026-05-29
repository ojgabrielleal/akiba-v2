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
        $user = User::where('id', '!=', 1)->where('is_virtual', false)->inRandomOrder()->first();
        $virtualUser = User::where('is_virtual', true)->inRandomOrder()->first();

        $this->seedAdministrator($admin);
        $this->seedAutoDJ($virtualUser);
        $this->seedPrograms($user);
    }

    private function seedAdministrator($user): void
    {
        if(!$user) return;

        Program::factory()
            ->withPrivate()
            ->for($user, 'host')
            ->create();
    }

    private function seedPrograms(?User $user): void
    {
       if(!$user) return;

        Program::factory()
            ->withFree()
            ->for($user, 'host')
            ->create();

        Program::factory()
            ->withPrivate()
            ->for($user, 'host')
            ->create();
    }

    private function seedAutoDJ(?User $user): void
    {
        if(!$user) return;

        Program::factory()
            ->withAutomatic()
            ->isAutoDj()
            ->for($user, 'host')
            ->create();
    }
}
