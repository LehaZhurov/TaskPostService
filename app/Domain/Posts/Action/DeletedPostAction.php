<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Post;

class DeletedPostAction
{
    //Удаляет пост
    public function execute(int $id): bool|null
    {
        $post = Post::findOrFail($id)->delete();
        return $post;
    }
}
