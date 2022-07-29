<?php

namespace App\Domain\Posts\Action;

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;

class AddPostInIndexElasticSearchAction
{
    private const HOST = 'http://elasticsearch:9200';

    public function execute(Model $data): array 
    {
        $client = ClientBuilder::create()->setHosts([self::HOST])->build();//Создание подключение к Elasticsearch
        $params = [
            'index' => 'posts',
            'id'    =>  $data->id,
            'body'  => [
                'title'         => $data->title,
                'text'          => $data->text,
                'preview'       => $data->preview,
                'tags'          => $data->tags,
                'user_id'       => $data->user_id,
                'rating'        => $data->rating,
                'created_at'    => $data->created_at,
            ]

        ];//Массив с параметрами где  id позволит найти этот пост , а body содержит данные поста  пост
        $response = $client->index($params);
        return $response->asArray();
    }
}
