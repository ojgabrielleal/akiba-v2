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

            if (array_key_exists('categories', $data)) {
                $uuids = collect($data['categories'])->pluck('uuid')->filter()->toArray();
                $relation = $post->categories()->whereNotIn('uuid', $uuids)->get();

                foreach($data['categories'] as $category) {
                    $relation->updateOrCreate(
                        ['uuid' => $category['uuid']], 
                        ['name' => $category['name']]
                    );
                }
            }

            if (array_key_exists('references', $data)) {
                $uuids = collect($data['references'])->pluck('uuid')->filter()->toArray();
                $relation = $post->references()->whereNotIn('uuid', $uuids)->get();

                foreach($data['references'] as $reference) {
                    $relation->updateOrCreate(
                        ['uuid' => $reference['uuid']], 
                        ['name' => $reference['name'], 'url' => $reference['url']]
                    );
                }
            }

            return $post;
        });
    }
}
