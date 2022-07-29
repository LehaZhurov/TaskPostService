<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Post;
use App\Domain\Posts\Action\CreatedTagAction;

class PatchPostAction
{   

    public function __construct(){
        $this->createdTag = new CreatedTagAction(); 
    }
    //Патчит поля поста в зависсимости от переданых данных
    public function execute(int $id, array $data): Post
    {
        $post = Post::find($id);
        if (isset($data['title'])) {
            $post->title = $data['title'];
        }
        if (isset($data['preview'])) {
            $post->preview = $data['preview'];
        }
        if (isset($data['tags'])) {
            //Создание новых тегов если они есть
            $tagIds = $this->createdTag->execute($data['tags']);
            //Привязка тегов к посту
            $post->tags()->sync($tagIds);
        }
        if (isset($data['text'])) {
            $post->text = $data['text'];
        }
        $post->save();
        return $post;
    }
}
