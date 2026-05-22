<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $postData = [
            'uuid' => $this->uuid,
            'slug' => $this->slug,
            'status' => $this->status,
            'title' => $this->title,
            'image' => $this->image,
            'cover' => $this->cover,
            'author' => UserResource::make($this->author),
            'references' => ReferenceResource::collection($this->references),
            'tags' => TagResource::collection($this->tags),
            'views' => $this->views_count,
        ];

        $postData = array_merge(
            $postData,
            $this->post(),
            $this->review($request),
        );

        return $postData;
    }

    public function post(): array 
    {
        if(!$this->review && !$this->event){
            return [
                'type' => 'post',
                'content' => $this->content,
                'reactions' => ReactionResource::collection($this->reactions)
            ];
        }

        return [];
    }

    public function review(Request $request): array
    {
        if($this->review){
            return [
                'type' => 'review',
                'year_of_release' => $this->review->year_of_release,
                'sinopse' => $this->review->sinopse,
                'opinions' => $this->reviewListOpinions($request),
                'review' => $this->reviewCurrentUserOpinion($request),
            ];
        }

        return [];
    }

    private function reviewCurrentUserOpinion(Request $request): array
    {
        $user = $request->user();
        $opinion = $this->review->opinions->first(
            fn ($opinion) => $opinion->user_id === $user->id
        );

        if ($opinion) {
            return OpinionResource::make($opinion)->resolve();
        }

        return $this->reviewGhostOpinion($user);
    }

    private function reviewListOpinions(Request $request): array
    {
        if (!$request->user()->hasPermission('post.review.opinion.list')) {
            return [];
        }

        $user = $request->user();
        $opinions = OpinionResource::collection($this->review->opinions)->resolve();

        $userOpinion = collect($opinions)->first(
            fn ($opinion) => $opinion['author']['uuid'] === $user->uuid
        );

        if (!$userOpinion) {
            return [
                $this->reviewGhostOpinion($user),
                ...$opinions,
            ];
        }

        return [
            $userOpinion,
            ...collect($opinions)
                ->reject(fn ($opinion) => $opinion['author']['uuid'] === $user->uuid)
                ->values()
                ->all(),
        ];
    }

    private function reviewGhostOpinion($user): array
    {
        return [
            'uuid' => null,
            'status' => null,
            'content' => null,
            'author' => UserResource::make($user),
        ];
    }
}
