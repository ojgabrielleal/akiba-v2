<?php

namespace App\Http\Controllers\Private;

use App\Actions\Post\CreatePostAction;
use App\Actions\Post\PostListAction;
use App\Actions\Post\UpdatePostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Resources\PublicationResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\HasFlashMessages;
use App\Traits\ResolvesUserLogged;
use Inertia\Inertia;

class PostController extends Controller
{
    use HasFlashMessages, ResolvesUserLogged;

    private $render = 'private/Post';

    /*
     * ======================
     * POSTS
     * ======================
     */

    public function indexPosts()
    {
        return PublicationResource::collection(
            app(PostListAction::class)->execute(request()->user())
        );
    }

    public function showPost(Post $post)
    {
        if (request()->user()->cannot('view', $post)) {
            return null;
        }

        return Inertia::render($this->render, [
            'post' => new PostResource($post->load(['tags', 'references', 'author'])),
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

    public function updatePost(CreatePostRequest $request, Post $post, UpdatePostAction $updatePostAction)
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

    public function deactivatePost(Post $post)
    {
        if (request()->user()->cannot('delete', $post)) {
            return null;
        }

        $post->update([
            'is_active' => false,
        ]);

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
            'posts' => $this->indexPosts(),
        ]);
    }
}
