<?php

namespace App\Http\ApiV1\Queries;

use App\Domain\Posts\Models\Voice;
use Illuminate\Support\Collection;

class GetPostVoicesQuerie
{
    //Возврощает коллекцию голосов поста у которых post_id равен переданому id 
    public function get(int $postId): Collection
    {
        $voices = Voice::query()->where('post_id', "=", $postId);
        return $voices->get();
    }
}
