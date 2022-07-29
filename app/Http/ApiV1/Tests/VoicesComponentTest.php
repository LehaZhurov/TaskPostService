<?php

use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;
use Database\Factories\VoiceFactory;
use Database\Factories\PostFactory;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Domain\Posts\Models\Voice;

uses(ApiV1ComponentTestCase::class);
uses()->group('component');

test('GET|/api/v1/posts/{id}/voices|200', function () {
    $postId = PostFactory::new()->create()->id;
    VoiceFactory::new()->state(['post_id' => $postId,])->count(10)->create();
    getJson("/api/v1/posts/{$postId}/voices")->assertStatus(200);
});

test('POST|/api/v1/posts/{id}/voices|200', function () {
    $postId = PostFactory::new()->create()->id;
    $testData = VoiceFactory::new()->definition();
    $testResponse = postJson("/api/v1/posts/{$postId}/voices", $testData)->assertStatus(200);
    //Проверка сохранения голоса 
    $vote = Voice::find($testResponse['data']['id']);
    expect($vote->id)->toBe($testResponse['data']['id']);
    expect($vote->voices)->toBe($testData['voices']);   
});

test('POST|/api/v1/posts/{id}/voices|400', function () {
    $postId = PostFactory::new()->create()->id;
    postJson("/api/v1/posts/{$postId}/voices")->assertStatus(400);
});

test('DELETE|/api/v1/posts/{id}/voices|200', function () {
    $postId = PostFactory::new()->create()->id;
    VoiceFactory::new()->state(['post_id' => $postId])->count(10)->create();
    deleteJson("/api/v1/posts/{$postId}/voices")->assertStatus(200);
    //Проверка что голоса были удаленны 
    $trashVoices = Voice::withTrashed()->where('post_id', $postId);
    $this->assertCount(10, $trashVoices->get()->all());
});

test('DELETE|/api/v1/posts/{id}/voices|404', function () {
    deleteJson('/api/v1/posts/1000000/voices')
        ->assertStatus(404);
});

test('DELETE|/api/v1/posts/{id}/voices/{voiceId}|200', function () {
    $postId = PostFactory::new()->create()->id;
    $voiceId = VoiceFactory::new()->state(['post_id' => $postId])->create()->id;
    deleteJson("/api/v1/posts/{$postId}/voices/{$voiceId}")->assertStatus(200);
    //Проверка того что голос был удален 
    $deletedAtVote = Voice::withTrashed()->find($voiceId)->deleted_at;
    $this->expect($deletedAtVote)->toBeObject();
});

test('DELETE|/api/v1/posts/{id}/voices/{voiceId}|404', function () {
    deleteJson('/api/v1/posts/100000/voices/100000')->assertStatus(404);
});

test('PATCH|/api/v1/posts/{id}/voices/{voiceId}|200', function () {
    $postId = PostFactory::new()->create()->id;
    $voiceFactory = new VoiceFactory();
    $voiceId = $voiceFactory->state(['post_id' => $postId])->create()->id;
    $testData = $voiceFactory->definition();
    $testResponse = patchJson("/api/v1/posts/{$postId}/voices/{$voiceId}", $testData)->assertStatus(200);
    //Проверка то что голос был изменен
    $voice = Voice::find($voiceId);
    expect($voice->id)->toBe($testResponse['data']['id']);
    expect($voice->voices)->toBe($testResponse['data']['voices']);
});

test('PATCH|/api/v1/posts/{id}/voices/{voiceId}|400', function () {
    $postId = PostFactory::new()->create()->id;
    $voiceFactory = new VoiceFactory();
    $voiceId = $voiceFactory->state(['post_id' => $postId])->create()->id;
    $testData = ['voices' => 0];
    patchJson("/api/v1/posts/{$postId}/voices/{$voiceId}", $testData)->assertStatus(400);
});

test('POST|/api/v1/posts/voices:search|200', function () {
    $postId = PostFactory::new()->create()->id;
    $testData = ['filter' => ['post_id' => $postId]];
    postJson('/api/v1/posts/voices:search', $testData)->assertStatus(200);
});

test('POST|/api/v1/posts/voices:search|400', function () {
    $testData = ['filter' => ['post_id' => -1]];
    postJson('/api/v1/posts/voices:search', $testData)->assertStatus(400);
});

test('RBC|GET|/api/v1/posts/{id}/voices', function () {
    $postId = PostFactory::new()->create()->id;
    VoiceFactory::new()->state(['post_id' => $postId])->count(10)->create();
    $testResponse = getJson("/api/v1/posts/{$postId}/voices");
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
    );
    $this->assertCount(10, $testResponse['data']);
});

test('RBC|POST|/api/v1/posts/{id}/voices', function () {
    $postId = PostFactory::new()->create()->id;
    $testData = VoiceFactory::new()->definition();
    $testResponse = postJson("/api/v1/posts/{$postId}/voices", $testData)->assertStatus(200);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('data.id')
            ->where('data.voices', $testData['voices'])
            ->where('data.post_id', $postId)
            ->where('data.user_id', $testData['user_id'])
            ->has('data.created_at')
            ->etc()
    );
});
test('RBC|DELETE|/api/v1/posts/{id}/voices', function () {
    $postId = PostFactory::new()->create()->id;
    VoiceFactory::new()->state(['post_id' => $postId])->count(10)->create();
    $testResponse = deleteJson("/api/v1/posts/{$postId}/voices");
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->where('data', null)
    );
});

test('RBC|DELETE|/api/v1/posts/{id}/voices/{voiceId}', function () {
    $postId = PostFactory::new()->create()->id;
    $voiceId = VoiceFactory::new()->state(['post_id' => $postId])->create()->id;
    $testResponse = deleteJson("/api/v1/posts/{$postId}/voices/{$voiceId}");
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->where('data', null)
    );
});
test('RBC|PATCH|/api/v1/posts/{id}/voices/{voiceId}', function () {
    $postId = PostFactory::new()->create()->id;
    $voiceFactory = new VoiceFactory();
    $voiceId = $voiceFactory->state(['post_id' => $postId])->create()->id;
    $testData = $voiceFactory->definition();
    $testResponse = patchJson("/api/v1/posts/{$postId}/voices/{$voiceId}", $testData);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('data.id')
            ->where('data.voices', $testData['voices'])
            ->where('data.post_id', $postId)
            ->has('data.created_at')
            ->etc()
    );
});
test('RBC|POST|/api/v1/posts/voices:search', function () {
    $postId = PostFactory::new()->create()->id;
    VoiceFactory::new()->state(['post_id' => $postId])->count(10)->create();
    $testData = ['filter' => ['post_id' => $postId]];
    $testResponse = postJson('/api/v1/posts/voices:search', $testData);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('meta')
            ->where('meta.pagination.total', 10)
            ->where('data.0.post_id', $postId)
            ->etc()
    );
});
