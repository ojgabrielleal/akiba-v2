<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserPreference;
use App\Models\UserSocial;
use App\Models\Role;
use App\Models\Activity;
use App\Models\Automatic;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\Program;
use App\Models\Podcast;
use App\Models\Post;
use App\Models\Review;
use App\Models\ReviewContent;
use App\Models\Task;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from User model relationships.
     */
    public function testPreferencesRelationship(): void
    {
        $preference = UserPreference::factory();

        $user = User::factory()
            ->has($preference, 'preferences')
            ->create();

        $this->assertContainsOnlyInstancesOf(UserPreference::class, $user->preferences);
    }

    public function testSocialsRelationship(): void
    {
        $social = UserSocial::factory();

        $user = User::factory()
            ->has($social, 'socials')
            ->create();

        $this->assertContainsOnlyInstancesOf(UserSocial::class, $user->socials);
    }

    public function testRolesRelationship(): void
    {
        $role = Role::factory();

        $user = User::factory()
            ->hasAttached($role, [], 'roles')
            ->create();

        $this->assertContainsOnlyInstancesOf(Role::class, $user->roles);
    }

    public function testActivitiesRelationship(): void
    {
        $activity = Activity::factory();

        $user = User::factory()
            ->has($activity, 'activities')
            ->create();

        $this->assertContainsOnlyInstancesOf(Activity::class, $user->activities);
    }

    public function testAutomaticRelationship(): void
    {
        $automatic = Automatic::factory();

        $user = User::factory()
            ->has($automatic, 'automatic')
            ->create();

        $this->assertContainsOnlyInstancesOf(Automatic::class, $user->automatic);
    }

    public function testCalendarRelationship(): void
    {
        $user = User::factory()->create();

        $calendar = Calendar::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertInstanceOf(User::class, $calendar->responsible);
    }

    public function testEventsRelationship(): void
    {
        $event = Event::factory();

        $user = User::factory()
            ->has($event, 'events')
            ->create();

        $this->assertContainsOnlyInstancesOf(Event::class, $user->events);
    }

    public function testProgramsRelationship(): void
    {
        $program = Program::factory();

        $user = User::factory()
            ->has($program, 'programs')
            ->create();

        $this->assertContainsOnlyInstancesOf(Program::class, $user->programs);
    }

    public function testPodcastsRelationship(): void
    {
        $podcast = Podcast::factory();

        $user = User::factory()
            ->has($podcast, 'podcasts')
            ->create();

        $this->assertContainsOnlyInstancesOf(Podcast::class, $user->podcasts);
    }

    public function testPostsRelationship(): void
    {
        $post = Post::factory();

        $user = User::factory()
            ->has($post, 'posts')
            ->create();

        $this->assertContainsOnlyInstancesOf(Post::class, $user->posts);
    }

    public function testReviewsRelationship(): void
    {
        $review = Review::factory()->create();
        $user = User::factory()->create();

        $reviewContent = ReviewContent::factory()
            ->for($review, 'review')
            ->for($user, 'author')
            ->create();

        $this->assertContainsOnlyInstancesOf(ReviewContent::class, $user->reviews);
    }

    public function testTasksRelationship(): void
    {
        $task = Task::factory();

        $user = User::factory()
            ->has($task, 'tasks')
            ->create();

        $this->assertContainsOnlyInstancesOf(Task::class, $user->tasks);
    }

    /**
     * Tests from User model scopes.
     */
    public function testActiveScope(): void
    {
        $activeUser = User::factory()
            ->create([
                'is_active' => true
            ]);

        $inactiveUser = User::factory()
            ->create([
                'is_active' => false
            ]);

        $users = User::active()->get();

        $this->assertTrue($users->contains($activeUser));
        $this->assertFalse($users->contains($inactiveUser));
    }

    /**
     * Tests from User model attributes.
     */
    public function testSlugAttribute(): void
    {
        $user = User::factory()->create(
            ['nickname' => 'sample-review-title']
        );

        $this->assertEquals('sample-review-title', $user->slug);
    }
}
