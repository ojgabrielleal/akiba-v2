<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Review;

use App\Http\Requests\Review\StoreReviewRequest;

use App\Http\Resources\ReviewResource;

use App\Services\Process\ImageProcessService;
use App\Traits\HasFlashMessages;

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
        if (request()->user()->cannot('viewAny', Review::class)) return null;

        return ReviewResource::collection(
            Review::with('reviews')->paginate(10)
        );
    }

    public function showReview(Review $review)
    {
        if (request()->user()->cannot('view', $review)) return null;

        return Inertia::render($this->render, [
            'reviews' => $this->indexReviews(),
            'review' => new ReviewResource(
                $review->load('reviews.author')
            ),
        ]);
    }

    public function createReview(StoreReviewRequest $request)
    {
        if ($request->user()->cannot('create', Review::class)) return null;

        $review = Review::create([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public'),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public'),
        ]);

        $review->reviews()->create([
            'user_id' => request()->user()->id,
            'content' => $request->input('review.content'),
        ]);

        return $this->flashMessage('save');
    }

    public function updateReview(Request $request, Review $review)
    {
        if ($request->user()->cannot('update', $review)) return null;

        $review->fill([
            'title' => $request->input('title'),
            'sinopse' => $request->input('sinopse'),
            'image' => $this->image->store('reviews', $request->file('image'), 'public', $review->image),
            'cover' => $this->image->store('reviews', $request->file('cover'), 'public', $review->cover),
        ]);

        if ($review->isDirty()) $review->save();

        $review->reviews()->updateOrCreate(
            ['uuid' => $request->input('review.uuid')],
            [
                'user_id' => $request->user()->id,
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
