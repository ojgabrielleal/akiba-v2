<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\ReviewContent;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        $user = User::where('id', '!=', 1)->inRandomOrder()->first();

        $this->seedAdministration($admin);
        $this->seedNonAdministrationContent($user);
    }

    private function seedAdministration(User $admin): void
    {
        $adminContent = ReviewContent::factory(5)
            ->for($admin, 'author');

        Review::factory(5)
            ->for($admin, 'author')
            ->has($adminContent, 'reviews')
            ->create();
    }

    private function seedNonAdministrationContent(User $user): void
    {
        $userContent = ReviewContent::factory(5)
            ->for($user, 'author');

        Review::factory(5)
            ->for($user, 'author')
            ->has($userContent, 'reviews')
            ->create();
    }
}
