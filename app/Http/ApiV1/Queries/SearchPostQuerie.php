<?php

namespace App\Http\ApiV1\Queries;

use App\Domain\Posts\Models\Post;
use App\Domain\Posts\Models\Tag;
use App\Http\ApiV1\Requests\SearchPostParams;
use App\Http\ApiV1\Support\Pagination\PageBuilderFactory;
use App\Http\ApiV1\Support\Search\SearchPostPage;
use InvalidArgumentException;

class SearchPostQuerie
{

    public const INCLUDE_VOICES = 'voices';


    public function find(SearchPostParams $params): SearchPostPage
    {
        $query = Post::query();
        //Перебор фильтров переданых в параметрах
        foreach ($params->getFilter() as $filter => $value) {
            switch ($filter) {
                case 'rating_gte':
                    $query->where('rating', '>=', $value);
                    break;
                case 'rating_lte':
                    $query->where('rating', '<=', $value);
                    break;
                case 'user_id':
                    $query->where('user_id', '=', $value);
                    break;
                case 'tags':
                        $query
                        ->join('post_tag','post_tag.post_id','=','posts.id')
                        ->join('tags','tags.id','=','post_tag.tag_id')
                        ->where('tags.tag',$value)
                        ->select('posts.*');
                    break;
                case 'title_like':
                    $query->where('title', 'like', "%{$value}%");
                    break;
                case 'text_like':
                    $query->where('text', 'like', "%{$value}%");
                    break;
                default:
                    throw new InvalidArgumentException("{$filter} фильтр не найден");
            }
        }
        //Использование фильтров к запросу из переданого параметра
        foreach ($params->getSort() as $sort => $value) {
            switch ($value) {
                case 'id':
                    $query->orderBy('posts.id', 'asc');
                    break;
                case '-id':
                    $query->orderBy('posts.id', 'desc');
                    break;
                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;
                case '-created_at':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'updated_at':
                    $query->orderBy('updated_at', 'asc');
                    break;
                case '-updated_at':
                    $query->orderBy('updated_at', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'asc');
                    break;
                case '-rating':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'default':
                    break;
                default:
                    throw new InvalidArgumentException("Не верное имя столбца в sort[{$sort}]");
            }
        }

        //Генерация пагинации 
        $pagination = (new PageBuilderFactory())->fromQuery($query->getQuery())->build()->pagination;
        //Всключение голосов пользователя 
        if ($params->isInclude(self::INCLUDE_VOICES) == true) {
            $query->with('voices');
        }
        $query->with('tags');//явное добавление связи с таблицей Tag
        $posts = $query->get();
        //Возврощение объекта с постами и пагинации
        return new SearchPostPage(
            posts: $posts,
            pagination: $pagination
        );
    }
}
