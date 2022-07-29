<?php

use App\Http\ApiV1\Support\Tests\ApiV1ComponentTestCase;
use Database\Factories\PostFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use App\Domain\Posts\Models\Post;

uses(ApiV1ComponentTestCase::class);
uses()->group('component');

test('POST|/api/v1/posts|200', function () {
    $testData = PostFactory::new()->definition();
    $testData['tags'] = ['php'];
    $testResponse = postJson('/api/v1/posts', $testData)->assertStatus(200);
    //Проверка сохранения поста в БД
    $postId = $testResponse['data']['id'];
    $post = Post::find($postId);
    expect($post->id)->toBe($testResponse['data']['id']);
    expect($post->title)->toBe($testData['title']);
});

test('POST|/api/v1/posts|400', function () {
    postJson('/api/v1/posts')
        ->assertStatus(400);
});

test("GET|api/v1/posts/{id}|200'", function () {
    $id = PostFactory::new()->create()->id;
    getJson('/api/v1/posts/' . $id)->assertStatus(200);
});

test('GET|/api/v1/posts/{id}|404', function () {
    getJson('/api/v1/posts/100000')
        ->assertStatus(404);
});

test('POST|/api/v1/posts:all|200', function () {
    postJson('/api/v1/posts:all')->assertStatus(200);
});


test('DELETE|/api/v1/posts/{id}|200', function () {
    $id = PostFactory::new()->create()->id;
    deleteJson('/api/v1/posts/' . $id)->assertStatus(200);
    //Проверка того что пост был удален
    $deletedAdPost = Post::withTrashed()->find($id)->deleted_at;
    $this->expect($deletedAdPost)->toBeObject();
});

test('DELETE|/api/v1/posts/{id}|404', function () {
    deleteJson('/api/v1/posts/11111111111')
        ->assertStatus(404);
});

test('PATCH|/api/v1/posts/{id}|200', function () {
    $factory = new PostFactory();
    $id = $factory->create()->id;
    $testData = $factory->definition();
    $testData['tags'] = ['php'];
    $testResponse = patchJson('/api/v1/posts/' . $id, $testData)->assertStatus(200);
    //Проверка того что пропатченый посты был сохранен и изменен
    $post = Post::find($id)->first();
    expect($post->id)->toBe($testResponse['data']['id']);
    expect($post->title)->toBe($testResponse['data']['title']);
    expect($post->preview)->toBe($testResponse['data']['preview']);
    expect($post->text)->toBe($testResponse['data']['text']);
    expect($post->user_id)->toBe($testResponse['data']['user_id']);
});

test('PATCH /api/v1/posts/{id} 400', function () {
    $factory = new PostFactory();
    $id = $factory->create()->id;
    $testData = ['title' => 0];
    patchJson('/api/v1/posts/' . $id, $testData)->assertStatus(400);
});

test('POST|/api/v1/posts:search|200(Case1)', function () {
    $countPost = rand(2, 20);
    $testData = ['filter' => ['user_id' => 2]];
    PostFactory::new()->state(['user_id' => 2])->count($countPost)->create();
    PostFactory::new()->count(3)->create();
    $testResponse = postJson('/api/v1/posts:search', $testData)->assertStatus(200);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('meta')
            ->where('data.0.user_id', 2)
            ->where('data.1.user_id', 2)
            ->where('meta.pagination.total', $countPost)
    );
});

test('POST|/api/v1/posts:search|400', function () {
    $testData = ['filter' => ['user_id' => -100]];
    postJson('/api/v1/posts:search', $testData)->assertStatus(400);
});

test('RBC|POST|api/v1/posts', function () {
    $testData = PostFactory::new()->definition();
    $testData['tags'] = ['php'];
    $testResponse = postJson('/api/v1/posts', $testData);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('data.id')
            ->where('data.title', $testData['title'])
            ->where('data.preview', $testData['preview'])
            ->where('data.text', $testData['text'])
            ->where('data.user_id', $testData['user_id'])
            ->has('data.created_at')
            ->etc()
    );
});
//Вот проверяю что 7 постов
test('RBC|POST|/api/v1/posts:all', function () {
    $countPost = rand(2, 20);
    PostFactory::new()->count($countPost)->create();
    $testResponse = postJson('/api/v1/posts:all');
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('meta')
            ->where('meta.pagination.total', $countPost) //
    );
});
test('RBC|PATCH|/api/v1/posts/{id}', function () {
    $factory = new PostFactory();
    $id = $factory->create()->id;
    $testData = $factory->definition();
    $testResponse = patchJson('/api/v1/posts/' . $id, $testData);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('data.id')
            ->where('data.title', $testData['title'])
            ->where('data.preview', $testData['preview'])
            ->where('data.text', $testData['text'])
            ->has('data.created_at')
            ->etc()
    );
});

test('RBC|POST|/api/v1/posts:search(Case2)', function () {
    $testResponse = postJson('/api/v1/posts:search');
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('meta')
    );
});
test('RBC|DELETE|/api/v1/posts/{id}', function () {
    $id = PostFactory::new()->create()->id;
    $testResponse = deleteJson('/api/v1/posts/' . $id);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->where('data', null)
    );
});
test('POST|/api/v1/posts:search|200(Case3)', function () {
    $testTitle = 'php the best';
    $countPost = rand(2, 20);
    $testData = ['filter' => ['user_id' => 2, 'title_like' => $testTitle]];
    PostFactory::new()->state(['user_id' => 2, 'title' => $testTitle])->count($countPost)->create();
    PostFactory::new()->count(3)->create();
    $testResponse = postJson('/api/v1/posts:search', $testData)->assertStatus(200);
    $testResponse->assertJson(
        fn (AssertableJson $json) => $json
            ->has('data')
            ->has('meta')
            ->where('data.0.user_id', 2)
            ->where('data.1.user_id', 2)
            ->where('data.0.title', $testTitle)
            ->where('data.1.title', $testTitle)
            ->where('meta.pagination.total', $countPost)
    );
});
