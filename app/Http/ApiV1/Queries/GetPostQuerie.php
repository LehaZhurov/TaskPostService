<?php

namespace App\Http\ApiV1\Queries;

use App\Domain\Posts\Models\Post;
use App\Http\ApiV1\Requests\SearchPostParams;

class GetPostQuerie
{
    const INCLUDE_VOICES = 'voices';
    //Возврощате пост с его голосами или без
    public function get(SearchPostParams $params, int $id): Post
    {
        $query = Post::findOrFail($id); //Поиска поста по id
        //Проверка нужно включить в результат голоса данного поста
        if ($params->isInclude(self::INCLUDE_VOICES)) {
            $query->with('voice');
        }
        $query->with('tags');//явное добавление связи с таблицей Tag
        $post = $query->get()->first();
        return $post;
    }
}
