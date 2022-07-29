<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Post;
use App\Domain\Posts\Action\CreatedTagAction;
use App\Domain\Posts\Action\AddPostInIndexElasticSearchAction;

class CreatedPostAction
{

    public function __construct(){
        $this->createdTag = new CreatedTagAction();
        $this->addIndexElasticSearch = new AddPostInIndexElasticSearchAction();
    }

    //Создаете пост из переданых параметров
    public function execute(array $data): Post
    {
        $post = new Post();
        $post->title = $data['title'];
        $post->preview = $data['preview'];
        $post->text = $data['text'];
        $post->user_id = $data['user_id'];
        $post->save();
        $post = $post->fresh();
        //Создание новых тегов если они есть
        $tagIds = $this->createdTag->execute($data['tags']);
        //Привязка тегов к посту
        $post->tags()->sync($tagIds);
        $post->with('tags');
        //Добавление поста в index поиска
        $this->addIndexElasticSearch->execute($post);
        return $post;
    }
}
