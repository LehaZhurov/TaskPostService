<?php

namespace App\Http\ApiV1\Queries;

use App\Domain\Posts\Models\Voice;
use App\Http\ApiV1\Requests\SearchVoiceParams;
use App\Http\ApiV1\Support\Pagination\PageBuilderFactory;
use App\Http\ApiV1\Support\Pagination\Page;

use InvalidArgumentException;

class SearchVoiceQuerie
{

    public function get(SearchVoiceParams $params): Page
    {
        $query = Voice::query();

        foreach ($params->getFilter() as $filter => $value) {
            switch ($filter) {
                case 'user_id':
                    $query->where('user_id', '=', $value);
                    break;
                case 'post_id':
                    $query->where('post_id', '=', $value);
                    break;
                default:
                    throw new InvalidArgumentException("{$filter} фильтр не найден");
            }
        }
        $page = (new PageBuilderFactory())->fromQuery($query->getQuery())->build();
        return $page;
    }
}
