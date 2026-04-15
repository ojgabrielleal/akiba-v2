<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReference;
use App\Models\PostReaction;
use App\Models\PostCategory;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Post model relationships.
     */
    public function testAuthorRelationship(): void
    {
        $user = User::factory()->create();

        $post = Post::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($post->author->is($user));
    }

    public function testReferencesRelationship(): void
    {
        $user = User::factory()->create();
        $reference = PostReference::factory(2);

        $post = Post::factory()
            ->for($user, 'author')
            ->has($reference, 'references')
            ->create();

        $firstReference = $post->references->first();

        $this->assertCount(2, $post->references);
        $this->assertContainsOnlyInstancesOf(PostReference::class, $post->references);
        $this->assertNotNull($firstReference);
        $this->assertTrue($firstReference->post->is($post));
    }

    public function testReactionsRelationship(): void
    {
        $user = User::factory()->create();
        $reaction = PostReaction::factory(2);

        $post = Post::factory()
            ->for($user, 'author')
            ->has($reaction, 'reactions')
            ->create();

        $firstReaction = $post->reactions->first();

        $this->assertCount(2, $post->reactions);
        $this->assertContainsOnlyInstancesOf(PostReaction::class, $post->reactions);
        $this->assertNotNull($firstReaction);
        $this->assertTrue($firstReaction->post->is($post));
    }

    public function testCategoriesRelationship(): void
    {
        $user = User::factory()->create();
        $category = PostCategory::factory(2);

        $post = Post::factory()
            ->for($user, 'author')
            ->has($category, 'categories')
            ->create();

        $firstCategory = $post->categories->first();

        $this->assertCount(2, $post->categories);
        $this->assertContainsOnlyInstancesOf(PostCategory::class, $post->categories);
        $this->assertNotNull($firstCategory);
        $this->assertTrue($firstCategory->post->is($post));
    }

    /**
     * Tests from Post model scopes.
     */
    public function testActiveScope(): void
    {
        $user = User::factory()->create();

        $activePost = Post::factory()
            ->for($user, 'author')
            ->state(['is_active' => true])
            ->create();

        $inactivePost = Post::factory()
            ->for($user, 'author')
            ->state(['is_active' => false])
            ->create();

        $activePosts = Post::active()->get();

        $this->assertTrue($activePosts->contains($activePost));
        $this->assertFalse($activePosts->contains($inactivePost));
    }

    public function testPublishedScope(): void
    {
        $user = User::factory()->create();

        $publishedPost = Post::factory()
            ->for($user, 'author')
            ->state(['type' => 'published'])
            ->create();

        $draftPost = Post::factory()
            ->for($user, 'author')
            ->state(['type' => 'draft'])
            ->create();

        $publishedPosts = Post::published()->get();

        $this->assertTrue($publishedPosts->contains($publishedPost));
        $this->assertFalse($publishedPosts->contains($draftPost));
    }

    public function testMineScope(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $myPost = Post::factory()
            ->for($user, 'author')
            ->create();

        $otherPost = Post::factory()
            ->for($otherUser, 'author')
            ->create();

        $this->actingAs($user);

        $myPosts = Post::mine()->get();

        $this->assertTrue($myPosts->contains($myPost));
        $this->assertFalse($myPosts->contains($otherPost));
    }


    /**
     * Tests from Post model attributes.
     */
    public function testSlugAttribute(): void
    {
        $user = User::factory()->create();

        $post = Post::factory()
            ->for($user, 'author')
            ->create([
                'title' => 'Sample Post Title'
            ]);

        $this->assertEquals('sample-post-title', $post->slug);
    }
}
