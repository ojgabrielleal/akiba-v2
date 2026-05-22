<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Concerns\HasFlashMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\CreateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    use HasFlashMessages;

    private ImageProcessService $image;

    private $render = 'private/Review';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    /*
     * ======================
     * REVIEWS
     * ======================
     */

    public function indexReviews()
    {
        if (request()->user()->cannot('viewAny', Review::class)) {
            return null;
        }

        return ReviewResource::collection(
            Review::with(['opinions', 'views'])->paginate(10)
        );
    }

    public function showReview(Review $review)
    {
        if (request()->user()->cannot('view', $review)) {
            return null;
        }

        return Inertia::render($this->render, [
            'reviews' => $this->indexReviews(),
            'review' => new ReviewResource(
                $review->load('opinions.author')
            ),
        ]);
    }

    public function createReview(CreateReviewRequest $request)
    {
        if ($request->user()->cannot('create', Review::class)) {
            return null;
        }

        $review = Review::create([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'year_of_release' => $request->input('year_of_release'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public'),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public'),
        ]);

        $review->opinions()->create([
            'user_id' => request()->user()->id,
            'status' => 'published',
            'content' => $request->input('review.content'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateReview(Request $request, Review $review)
    {
        if ($request->user()->cannot('update', $review)) {
            return null;
        }

        $review->fill([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'year_of_release' => $request->input('year_of_release'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public', $review->image),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public', $review->cover),
        ]);

        if ($review->isDirty()) {
            $review->save();
        }

        $review->opinions()->updateOrCreate(
            ['uuid' => $request->input('review.uuid')],
            [
                'user_id' => $request->user()->id,
                'status' => 'published',
                'content' => $request->input('review.content'),
            ]
        );

        return $this->flashMessage('update');
    }

    /*
     * ======================
     * RENDER
     * ======================
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'reviews' => $this->indexReviews(),
        ]);
    }
}
