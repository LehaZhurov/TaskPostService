<?php

namespace App\Http\ApiV1\Resources;

use App\Http\ApiV1\Support\Resources\BaseJsonResource;
use App\Http\ApiV1\Resources\VoicesResource;
use App\Http\ApiV1\Resources\TagResource;

class PostAndVoicesResource extends BaseJsonResource
{
    /**
     * toArray function
     *
     * @param [type] $data
     * @return array
     */
    public function toArray($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'preview' => $this->preview,
            'tags' => TagResource::collection($this->tags),
            'text' => $this->text,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'rating' => $this->rating,
            'voices' => VoicesResource::collection($this->whenLoaded('voices')),
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
