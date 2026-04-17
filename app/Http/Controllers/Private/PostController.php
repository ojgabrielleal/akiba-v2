<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Post;

use App\Http\Requests\Post\StorePostRequest;

use App\Http\Resources\PostResource;
use App\Services\Process\ImageProcessService;

use App\Traits\HasFlashMessages;
use App\Traits\ResolvesUserLogged;

class PostController extends Controller
{
    use HasFlashMessages, ResolvesUserLogged;

    private ImageProcessService $image;
    private $render = 'private/Post';

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

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
                    ->with('author')
                    ->latest()
                    ->paginate(10)
            );
        }

        return PostResource::collection(
            Post::with('author')
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

    public function createPost(StorePostRequest $request)
    {
        if ($request->user()->cannot('create', Post::class)) return null;

        $post = Post::create([
            'user_id' => request()->user()->id,
            'type' => $request->input('type'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $this->image->store('posts', $request->file('image'), 'public'),
            'cover' => $this->image->store('posts', $request->file('cover'), 'public'),
        ]);

        foreach ($request->input('categories') as $category) {
            $post->categories()->create([
                'name' => $category['name'],
            ]);
        }

        foreach ($request->input('references') as $reference) {
            $post->references()->create([
                'name' => $reference['name'],
                'url' => $reference['url'],
            ]);
        }

        return $this->flashMessage('save');
    }

    public function updatePost(Request $request, Post $post)
    {
        if ($request->user()->cannot('update', $post)) return null;

        $post->fill([
            'type' => $request->input('type', $post->type),
            'title' => $request->input('title', $post->title),
            'content' => $request->input('content', $post->content),
            'image' => $this->image->store('posts', $request->file('image'), 'public', $post->image),
            'cover' => $this->image->store('posts', $request->file('cover'), 'public', $post->cover),
        ]);

        if ($post->isDirty()) $post->save();

        foreach ($request->input('categories') as $category) {
            $post->categories()->where('uuid', $category['uuid'])->update([
                'name' => $category['name'],
            ]);
        }

        foreach ($request->input('references') as $reference) {
            $post->references()->where('uuid', $reference['uuid'])->update([
                'name' => $reference['name'],
                'url' => $reference['url'],
            ]);
        }

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
