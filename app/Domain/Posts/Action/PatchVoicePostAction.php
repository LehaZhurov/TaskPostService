<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Voice;
use App\Domain\Posts\Action\UpdateTotalRatingAction;

class PatchVoicePostAction
{
    public function __construct()
    {
        $this->updatePostTotalRating = new UpdateTotalRatingAction();
    }
    //Патчит голос поста в зависимости от переданых параметров
    public function execute(int $postId, int $voiceId, int $vote): Voice
    {
        $voice = Voice::findOrFail($voiceId)->first();
        $voice->voices = $vote;
        $voice->save();
        $this->updatePostTotalRating->execute($postId); //Вызов экшена который обновить суммарный рейтинг поста
        return $voice;
    }
}
