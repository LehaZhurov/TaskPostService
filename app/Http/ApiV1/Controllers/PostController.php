<?php

namespace App\Http\ApiV1\Controllers;

use App\Http\ApiV1\Requests\CreatePostsRequest;
use App\Http\ApiV1\Requests\PatchPostRequest;
use App\Http\ApiV1\Requests\SearchPostsRequest;
use App\Http\ApiV1\Resources\PostResource;
use App\Http\ApiV1\Resources\PostAndVoicesResource;
use App\Http\ApiV1\Resources\SearchPagePostResource;
use App\Http\ApiV1\Resources\PostsPageResource;
use App\Domain\Posts\Action\CreatedPostAction;
use App\Domain\Posts\Action\DeletedPostAction;
use App\Domain\Posts\Action\PatchPostAction;
use App\Http\ApiV1\Queries\AllPostQuerie;
use App\Http\ApiV1\Queries\GetPostQuerie;
use App\Http\ApiV1\Queries\SearchPostQuerie;
use App\Http\ApiV1\Support\Resources\EmptyResource;

class PostController
{
    public function index(AllPostQuerie $query): PostsPageResource
    {
        $page = $query->get();
        return new PostsPageResource($page);
    }

    public function store(CreatePostsRequest $request, CreatedPostAction $action): PostResource
    {
        $post = $action->execute($request->all());
        return new PostResource($post);
    }

    public function show(GetPostQuerie $query,SearchPostsRequest $request, int $postId): PostAndVoicesResource
    {
        $post = $query->get($request, $postId);
        return new PostAndVoicesResource($post);
    }

    public function destroy(DeletedPostAction $action, int $postId): EmptyResource
    {
        $action->execute($postId);
        return new EmptyResource();
    }

    public function update(PatchPostAction $action,PatchPostRequest $request, int $postId): PostResource
    {
        $post = $action->execute($postId, $request->all());
        return new PostResource($post);
    }

    public function search(SearchPostsRequest $request, SearchPostQuerie $query)
    {
        $posts = $query->find($request);
        return new SearchPagePostResource($posts);
    }
}
