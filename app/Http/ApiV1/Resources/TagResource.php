<?php

namespace App\Http\ApiV1\Resources;

use App\Http\ApiV1\Support\Resources\BaseJsonResource;
use App\Domain\Posts\Models\Tag;

/**
 * @mixin Tag
 */

class TagResource extends BaseJsonResource
{
    /**
     * toArray 
     *
     * @param [type] $resource
     * @return string
     */
    public function toArray($resource): string
    {
        return $this->tag;
    }
}
