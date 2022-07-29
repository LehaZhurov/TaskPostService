<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Voice;
use App\Domain\Posts\Action\UpdateTotalRatingAction;

class DeletedAllVoicesPostAction
{
    public function __construct()
    {
        $this->updatePostTotalRating = new UpdateTotalRatingAction();
    }
    //Удаляет все голоса по post_id
    public function execute(int $id): void
    {
        Voice::query()->where('post_id', $id)->delete();
        $this->updatePostTotalRating->execute($id); //Вызов экшена который обновить суммарный рейтинг поста

    }
}
