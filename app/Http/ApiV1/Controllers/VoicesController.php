<?php

namespace App\Http\ApiV1\Controllers;

use Illuminate\Http\Request;
use App\Domain\Posts\Action\CreatedPostVoicesAction;
use App\Domain\Posts\Action\DeletedAllVoicesPostAction;
use App\Domain\Posts\Action\DeletedVoicePostAction;
use App\Domain\Posts\Action\PatchVoicePostAction;
use App\Http\ApiV1\Requests\CreatePostVoiceRequest;
use App\Http\ApiV1\Requests\PatchPostVoicesRequest;
use App\Http\ApiV1\Requests\SearchPostVoicesRequest;
use App\Http\ApiV1\Resources\VoicesResource;
use App\Http\ApiV1\Support\Resources\EmptyResource;
use App\Http\ApiV1\Queries\GetPostVoicesQuerie;
use App\Http\ApiV1\Queries\SearchVoiceQuerie;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domain\Posts\Action\UpdateTotalRatingAction;

class VoicesController
{
    public function index(GetPostVoicesQuerie $query, int $postId)
    {
        $voices = $query->get($postId);
        return VoicesResource::collection($voices);
    }

    public function store(CreatePostVoiceRequest $request, CreatedPostVoicesAction $action, int $postId): VoicesResource
    {
        $voice = $action->execute($postId, $request->all());
        return new VoicesResource($voice);
    }

    public function destroyAll(DeletedAllVoicesPostAction $action, int $postId): EmptyResource
    {
        $action->execute($postId);
        return new EmptyResource();
    }

    public function destroy(DeletedVoicePostAction $action, int $postId, int $voiceId): EmptyResource
    {
        $action->execute($postId, $voiceId);
        return new EmptyResource();
    }

    public function update(PatchVoicePostAction $action, PatchPostVoicesRequest $request, int $postId, int $voiceId): VoicesResource
    {
        $voice = $action->execute($postId, $voiceId, $request->input('voices'));
        return new VoicesResource($voice);
    }

    public function search(SearchPostVoicesRequest $request, SearchVoiceQuerie $query): AnonymousResourceCollection
    {
        $page = $query->get($request);
        return VoicesResource::collectPage($page);
    }
}
