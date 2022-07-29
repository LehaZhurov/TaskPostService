<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Voice;
use App\Domain\Posts\Action\UpdateTotalRatingAction;

class DeletedVoicePostAction
{
    public function __construct()
    {
        $this->updatePostTotalRating = new UpdateTotalRatingAction();
    }
    //Удаляет один определеный голос
    public function execute(int $postId, int $voiceId): void
    {
        Voice::findOrFail($voiceId)->delete();
        $this->updatePostTotalRating->execute($postId); //Вызов экшена который обновить суммарный рейтинг поста
    }
}
