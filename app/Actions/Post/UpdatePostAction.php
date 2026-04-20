<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Services\Process\ImageProcessService;
use Illuminate\Http\UploadedFile;

class UpdatePostAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Post $post, array $data, ?UploadedFile $imageFile, ?UploadedFile $coverFile): Post
    {
        $post->fill([
            'type' => $data['type'] ?? $post->type,
            'title' => $data['title'] ?? $post->title,
            'content' => $data['content'] ?? $post->content,
            'image' => $this->image->store('posts', $imageFile, 'public', $post->image),
            'cover' => $this->image->store('posts', $coverFile, 'public', $post->cover),
        ]);

        if ($post->isDirty()) {
            $post->save();
        }

        if (!empty($data['categories'])) {
            foreach ($data['categories'] as $category) {
                $post->categories()->updateOrCreate([
                    'uuid' => $category['uuid'],
                ], [
                    'name' => $category['name'],
                ]);
            }
        }

        if (!empty($data['references'])) {
            foreach ($data['references'] as $reference) {
                $post->references()->where('uuid', $reference['uuid'])->update([
                    'name' => $reference['name'],
                    'url' => $reference['url'],
                ]);
            }
        }

        return $post;
    }
}
