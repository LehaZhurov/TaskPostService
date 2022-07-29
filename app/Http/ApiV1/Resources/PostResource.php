<?php

namespace App\Http\ApiV1\Resources;

use App\Http\ApiV1\Support\Resources\BaseJsonResource;
use App\Http\ApiV1\Resources\TagResource;

class PostResource extends BaseJsonResource
{
    /**
     * to Array
     *
     * @param [type] $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'preview' => $this->preview,
            'text' => $this->text,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'rating'  => $this->rating,
            'tags' => TagResource::collection($this->tags)

        ];
    }
}
