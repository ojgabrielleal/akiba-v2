<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\ReviewContent;
use App\Models\User;
use App\Models\Review;

class ReviewContentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from ReviewContent model relationships.
     */
    public function testAuthorRelationship(): void
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        $reviewContent = ReviewContent::factory()
            ->for($user, 'author')
            ->for($review, 'review')
            ->create();

        $this->assertTrue($reviewContent->author->is($user));
    }

    public function testReviewRelationship(): void
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        $reviewContent = ReviewContent::factory()
            ->for($user, 'author')
            ->for($review, 'review')
            ->create();

        $this->assertTrue($reviewContent->review->is($review));
    }
}
