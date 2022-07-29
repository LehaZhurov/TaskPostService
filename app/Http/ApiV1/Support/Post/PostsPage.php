<?php

namespace App\Http\ApiV1\Support\Post;

use Illuminate\Support\Collection;

class PostsPage
{
    public function __construct(public array|Collection $posts, public $pagination)
    {
    }
}
