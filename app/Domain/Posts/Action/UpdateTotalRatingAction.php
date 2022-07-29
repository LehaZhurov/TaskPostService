<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Post;

class UpdateTotalRatingAction
{

    //Считает сумарный рейтинг поста 
    public function execute(int $postId): int
    {
        $post = Post::findOrFail($postId);
        $disVoices = $post->voices()->where('voices', -1)->count(); //Получает отрицательный голоса
        $posVoices = $post->voices()->where('voices', 1)->count(); //Положительные
        $totalRating = $posVoices - $disVoices; //Получает разницу
        $post->rating = $totalRating; //Обновляте суммарный рейтинг
        $post->save();
        return $totalRating;
    }
}
