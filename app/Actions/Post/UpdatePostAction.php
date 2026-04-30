<?php

namespace App\Actions\Post;

use App\Models\Post;
use App\Services\Process\ImageProcessService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UpdatePostAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(Post $post, array $data, ?UploadedFile $imageFile, ?UploadedFile $coverFile): Post
    {
        return DB::transaction(function () use ($post, $data, $imageFile, $coverFile) {
            $post->fill([
                'type' => array_key_exists('type', $data) ? $data['type'] : $post->type,
                'title' => array_key_exists('title', $data) ? $data['title'] : $post->title,
                'content' => array_key_exists('content', $data) ? $data['content'] : $post->content,
                'image' => $this->image->store('posts', $imageFile, 'public', $post->image),
                'cover' => $this->image->store('posts', $coverFile, 'public', $post->cover),
            ]);

            if ($post->isDirty()) {
                $post->save();
            }

            if (array_key_exists('categories', $data)) {
                $this->syncRelation(
                    $post->categories(),
                    $data['categories'] ?? [],
                    fn (array $category) => ['name' => $category['name']]
                );
            }

            if (array_key_exists('references', $data)) {
                $this->syncRelation(
                    $post->references(),
                    $data['references'] ?? [],
                    fn (array $reference) => [
                        'name' => $reference['name'],
                        'url' => $reference['url'],
                    ]
                );
            }

            return $post;
        });
    }

    private function syncRelation(HasMany $relation, array $items, callable $payload): void
    {
        $items = collect($items);
        $uuidsToKeep = $items->pluck('uuid')->filter()->toArray();

        $relation->whereNotIn('uuid', $uuidsToKeep)->delete();

        foreach ($items as $item) {
            if (! empty($item['uuid'])) {
                $relation->updateOrCreate(['uuid' => $item['uuid']], $payload($item));

                continue;
            }

            $relation->create($payload($item));
        }
    }
}
