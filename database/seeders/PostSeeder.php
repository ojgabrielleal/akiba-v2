<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReference;
use App\Models\PostReaction;
use App\Models\PostCategory;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        $user = User::inRandomOrder()->first();

        Post::factory(5)
            ->for($admin, 'author')
            ->has(PostReference::factory(2), 'references')
            ->has(PostReaction::factory(5), 'reactions')
            ->has(PostCategory::factory(2), 'categories')
            ->create();

        Post::factory(15)
            ->for($user, 'author')
            ->has(PostReference::factory(2), 'references')
            ->has(PostReaction::factory(5), 'reactions')
            ->has(PostCategory::factory(2), 'categories')
            ->create();
    }
}
