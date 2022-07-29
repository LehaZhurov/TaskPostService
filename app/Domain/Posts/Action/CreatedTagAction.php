<?php

namespace App\Domain\Posts\Action;

use App\Domain\Posts\Models\Tag;

class CreatedTagAction
{

    public function execute(array $tagsList = []): array
    {
        $tagIds = []; //Массив с id тегов
        $queryTag = Tag::query();
        foreach ($tagsList as $tag => $name) {
            $searchTag = $queryTag->where('tag', '=', $name);
            if (!$searchTag->exists()) {
                $queryTag = new Tag();
                $queryTag->tag = $name;
                $queryTag->save();
                $tagIds[] = $queryTag->id;
            } else {
                $tagIds[] = $searchTag->first()->id;
            }
        }
        return $tagIds;
    }
}
