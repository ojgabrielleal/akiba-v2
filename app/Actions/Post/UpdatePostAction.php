<?php

namespace App\Actions\Post;

use Illuminate\Support\Facades\DB;
use App\Services\Process\ImageProcessService;

use App\Models\Post;

class UpdatePostAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            $post->fill([
                'type' => $data['type'],
                'title' =>  $data['title'],
                'content' => $data['content'],
                'image' => $this->image->store('posts', $data['image'], 'public', $post->image),
                'cover' => $this->image->store('posts', $data['cover'], 'public', $post->cover),
            ]);

            if ($post->isDirty()){
                $post->save();
            }

            if (!empty($data['categories'])) {
                foreach($data['categories'] as $category) {
                    $post->categories()->where('uuid', $category['uuid'])->update(
                        ['name' => $category['name']]
                    );
                }
            }

            if (!empty($data['references'])) {
                foreach($data['references'] as $reference) {
                    $post->references()->where('uuid', $reference['uuid'])->update([
                        'name' => $reference['name'], 
                        'url' => $reference['url']
                    ]);
                }
            }

            return $post;
        });
    }
}
