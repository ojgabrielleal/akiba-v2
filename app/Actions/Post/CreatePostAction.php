<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreatePostAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(string $userId, array $data, ?UploadedFile $imageFile, ?UploadedFile $coverFile): Post
    {
        return DB::transaction(function () use ($userId, $data, $imageFile, $coverFile) {
            $post = Post::create([
                'user_id' => $userId,
                'type' => $data['type'] ?? null,
                'title' => $data['title'] ?? null,
                'content' => $data['content'] ?? null,
                'image' => $this->image->store('posts', $imageFile, 'public'),
                'cover' => $this->image->store('posts', $coverFile, 'public'),
            ]);

            if (! empty($data['categories'])) {
                foreach ($data['categories'] as $category) {
                    $post->categories()->create([
                        'name' => $category['name'],
                    ]);
                }
            }

            if (! empty($data['references'])) {
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
