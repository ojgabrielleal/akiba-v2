<?php

namespace App\Actions\Post;

use Illuminate\Http\UploadedFile;
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

    public function execute(Post $post,array $data, ?UploadedFile $image = null, ?UploadedFile $cover = null): Post
    {
        return DB::transaction(function () use ($post, $data, $image, $cover) {
            $post->fill([
                'type' => $data['type'],
                'title' =>  $data['title'],
                'content' => $data['content'],
                'image' => $this->image->store('posts', $image, 'public', $post->image),
                'cover' => $this->image->store('posts', $cover, 'public', $post->cover),
            ]);

            if ($post->isDirty()){
                $post->save();
            }

            if (!empty($data['tags'])) {
                foreach($data['tags'] as $tag) {
                    $post->tags()->where('uuid', $tag['uuid'])->update(
                        ['name' => $tag['name']]
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
