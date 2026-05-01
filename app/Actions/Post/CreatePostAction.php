<?php

namespace App\Actions\Post;

use Illuminate\Support\Facades\DB;
use App\Services\Process\ImageProcessService;

use App\Models\User;
use App\Models\Post;

class CreatePostAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(User $user, array $data): Post
    {
        return DB::transaction(function () use ($user, $data) {
            $post = Post::create([
                'user_id' => $user->id,
                'type' => $data['type'],
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => $this->image->store('posts', $data['image'], 'public'),
                'cover' => $this->image->store('posts', $data['cover'], 'public'),
            ]);

            if (!empty($data['categories'])) {
                foreach ($data['categories'] as $category) {
                    $post->categories()->create([
                        'name' => $category['name'],
                    ]);
                }
            }

            if (!empty($data['references'])) {
                foreach ($data['references'] as $reference) {
                    $post->references()->create([
                        'name' => $reference['name'],
                        'url' => $reference['url'],
                    ]);
                }
            }

            return $post;
        });
    }
}
