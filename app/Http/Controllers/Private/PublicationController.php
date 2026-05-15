<?php

namespace App\Http\Controllers\Private;

use App\Actions\Publication\DeactivatePublicationAction;
use App\Actions\Publication\IndexPublicationAction;
use App\Actions\Post\CreatePostAction;
use App\Actions\Post\UpdatePostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Resources\PublicationResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\HasFlashMessages;
use App\Traits\ResolvesUserLogged;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicationController extends Controller
{
    use HasFlashMessages, ResolvesUserLogged;

    private $render = 'private/Publication';

    /*
     * ======================
     * POSTS
     * ======================
     */

    public function indexPublications()
    {
        return PublicationResource::collection(
            app(IndexPublicationAction::class)->execute(request()->user())
        );
    }

    public function showPost(Post $post)
    {
        if (request()->user()->cannot('view', $post)) {
            return null;
        }

        return Inertia::render($this->render, [
            'post' => new PostResource(
                $post->load(['categories', 'references', 'author'])
            ),
            'publications' => $this->indexPublications(),
        ]);
    }

    public function createPost(CreatePostRequest $request, CreatePostAction $createPostAction)
    {
        if ($request->user()->cannot('create', Post::class)) {
            return null;
        }

        $createPostAction->execute(
            $request->user()->id,
            $request->all(),
            $request->file('image'),
            $request->file('cover')
        );

        return $this->flashMessage('save');
    }

    public function updatePost(Request $request, Post $post, UpdatePostAction $updatePostAction)
    {
        if ($request->user()->cannot('update', $post)) {
            return null;
        }

        $updatePostAction->execute(
            $post,
            $request->all(),
            $request->file('image'),
            $request->file('cover')
        );

        return $this->flashMessage('update');
    }

    public function deactivatePublication(Request $request, DeactivatePublicationAction $deactivatePublicationAction)
    {
        if (! $request->user()->hasPermission('publication.deactivate')) {
            return null;
        }

        $deactivatePublicationAction->execute(
            $request->input('model'),
            $request->input('uuid')
        );

        return $this->flashMessage('deactivate');
    }

    /*
     * ======================
     * RENDER
     * ======================
     */

    public function render()
    {
        return Inertia::render($this->render, [
            'publications' => $this->indexPublications(),
        ]);
    }
}
