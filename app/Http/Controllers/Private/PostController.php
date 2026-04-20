<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Post;

use App\Http\Requests\Post\StorePostRequest;

use App\Http\Resources\PostResource;

use App\Actions\Post\CreatePostAction;
use App\Actions\Post\UpdatePostAction;

use App\Traits\HasFlashMessages;
use App\Traits\ResolvesUserLogged;

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
        if (request()->user()->cannot('viewAny', Post::class)) return null;

        if (!request()->user()->hasPermission('post.list')) {
            return PostResource::collection(
                Post::mine()
                    ->with(['author', 'views'])
                    ->latest()
                    ->paginate(10)
            );
        }

        return PostResource::collection(
            Post::with(['author', 'views'])
                ->latest()
                ->paginate(10)
        );
    }

    public function showPost(Post $post)
    {
        if (request()->user()->cannot('view', $post)) return null;

        return Inertia::render($this->render, [
            'post' => new PostResource(
                $post->load('categories', 'references', 'author')
            ),
            'posts' => $this->indexPosts(),
        ]);
    }

    public function createPost(StorePostRequest $request, CreatePostAction $createPostAction)
    {
        if ($request->user()->cannot('create', Post::class)) return null;

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
        if ($request->user()->cannot('update', $post)) return null;

        $updatePostAction->execute(
            $post,
            $request->all(),
            $request->file('image'),
            $request->file('cover')
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
            'posts' => $this->indexPosts(),
        ]);
    }
}
