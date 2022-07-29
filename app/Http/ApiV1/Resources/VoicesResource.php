<?php

namespace App\Http\ApiV1\Resources;

use App\Http\ApiV1\Support\Resources\BaseJsonResource;

class VoicesResource extends BaseJsonResource
{

    public function toArray($data): array
    {
        return [
            'id' => $this->id,
            'voices' => $this->voices,
            'user_id' => $this->user_id,
            'post_id' => $this->post_id,
            'created_at' => $this->created_at,
        ];
    }
}
