<?php

namespace App\Http\ApiV1\Queries;

use App\Domain\Posts\Models\Post;
use App\Http\ApiV1\Support\Pagination\PageBuilderFactory;
use App\Http\ApiV1\Support\Post\PostsPage;

class AllPostQuerie
{
    //Возвращает страницу с items и pagination
    public  function get(): PostsPage
    {
        $posts = Post::orderBy('id', 'desc');
        $pagination = (new PageBuilderFactory())->fromQuery($posts->getQuery())->build()->pagination;
        $posts->with('tags');
        $posts = $posts->get();
        return new PostsPage(
            posts: $posts,
            pagination: $pagination
        );
    }
}
