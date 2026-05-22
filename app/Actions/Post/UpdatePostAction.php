<?php

namespace App\Actions\Post;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Services\Process\ImageProcessService;

use InvalidArgumentException;

use App\Models\Post;
use App\Models\User;

class UpdatePostAction
{
    private ImageProcessService $image;

    public function __construct(ImageProcessService $image)
    {
        $this->image = $image;
    }

    public function execute(User $user, Post $post, array $data, ?UploadedFile $image = null, ?UploadedFile $cover = null, string $module = 'post', bool $updateMetadata = true): Post
    {
        return DB::transaction(function () use ($user, $post, $data, $image, $cover, $module, $updateMetadata) {
             switch ($module) {
                case 'post':
                    $post = $this->updatePost($post, $data, $image, $cover);
                    break;
                case 'review':
                    $post = $updateMetadata
                        ? $this->updateReview($user, $post, $data, $image, $cover)
                        : $this->updateReviewOpinion($user, $post, $data);
                    break;
                default:
                    throw new InvalidArgumentException("Invalid post update type [{$module}].");
            }
        
            if ($updateMetadata && !empty($data['tags'])) {
                foreach($data['tags'] as $tag) {
                    $post->tags()->where('uuid', $tag['uuid'])->update(
                        ['name' => $tag['name']]
                    );
                }
            }

            if ($updateMetadata && !empty($data['references'])) {
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

    public function updatePost(Post $post, array $data, ?UploadedFile $image, ?UploadedFile $cover): Post
    {
        $post->fill($this->postData(
            $post,
            $data,
            $image,
            $cover,
            $data['status'],
            $data['content']
        ));

        if ($post->isDirty()){
            $post->save();
        }

        return $post;
    }

    public function updateReviewOpinion(User $user, Post $post, array $data): Post
    {
        $review = $post->review()->first();

        $review->opinions()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => $data['review']['status'],
                'content' => $data['review']['content'],
            ]
        );

        return $post;
    }

    public function updateReview(User $user, Post $post, array $data, ?UploadedFile $image, ?UploadedFile $cover): Post
    {
        $post->fill($this->postData($post, $data, $image, $cover));

        if ($post->isDirty()){
            $post->save();
        }

        $review = $post->review()->firstOrFail();

        $review->update([
            'year_of_release' => $data['year_of_release'],
            'sinopse' => $data['sinopse'],
        ]);

        $review->opinions()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => $data['review']['status'],
                'content' => $data['review']['content'],
            ]
        );

        return $post;
    }

    public function postData(Post $post, array $data, ?UploadedFile $image, ?UploadedFile $cover, string $status = 'published', ?string $content = null): array
    {
        return [
            'status' => $status,
            'title' =>  $data['title'],
            'content' => $content,
            'image' => $this->image->store('posts', $image, 'public', $post->image),
            'cover' => $this->image->store('posts', $cover, 'public', $post->cover),
        ];
    }
}
