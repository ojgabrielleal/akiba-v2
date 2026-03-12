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
        $user = User::inRandomOrder()->first();
        
        $adminContent = ReviewContent::factory(5)
            ->for($admin, 'author');

        $userContent = ReviewContent::factory(5)
            ->for($user, 'author');

        Review::factory(5)
            ->has($adminContent, 'reviews')
            ->create();
            
        Review::factory(5)
            ->has($userContent, 'reviews')
            ->create();
    }
}
