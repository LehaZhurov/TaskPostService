<?php
namespace App\Http\ApiV1\Resources;
 
use App\Http\ApiV1\Support\Resources\BaseJsonResource;
use App\Http\ApiV1\Resources\PostResource;

/**
 * @mixin Posts
 * @mixin Page
 */

class PostsPageResource extends BaseJsonResource
{
    public function toArray($resquest): array
    {
        return [
            'data' => PostResource::collection($this->posts),
            'meta' => ['pagination' => $this->pagination]
        ];
    }
}