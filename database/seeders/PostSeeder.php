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
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'administrator');
        })->first();

        Post::factory()->count(5)
            ->for($admin, 'author')
            ->has(PostReference::factory()->count(2), 'references')
            ->has(PostReaction::factory()->count(5), 'reactions')
            ->has(PostCategory::factory()->count(2), 'categories')
            ->create();

        Post::factory()->count(15)
            ->for(User::inRandomOrder()->first(), 'author')
            ->has(PostReference::factory()->count(2), 'references')
            ->has(PostReaction::factory()->count(3), 'reactions')
            ->has(PostCategory::factory()->count(2), 'categories')
            ->create();
    }
}
