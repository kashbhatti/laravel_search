<?php

uses(Tests\TestCase::class);

test('no query validation error', function () {
    $response = $this->post('/search', [
        'query' => null,
        'sort' => 'asc',
        'offSet' => 0,
    ]);

    $response->assertStatus(302); // validation failed
});

test('api test with authentication', function () {
    $user = \App\Models\User::find(1);

    $response = $this->actingAs($user)
        ->post('/api/search', [
            'query' => 'ipad',
            'sort' => 'asc',
            'offSet' => 0,
        ]);

    $response->assertStatus(200);
});

test('search returns data', function () {
    $repository = new \App\Repositories\SearchRepository;
    $action = new \App\Actions\Search($repository);
    $dto = new \App\DataTransferObjects\SearchDto('ipad', 0, 'asc');
    $data = $action->handle($dto);
    $count = count($data);

    expect($count)->toBeGreaterThan(0);
});

test('search returns data without sort parameter', function () {
    $repository = new \App\Repositories\SearchRepository;
    $action = new \App\Actions\Search($repository);
    $dto = new \App\DataTransferObjects\SearchDto('ipad', 0, null);
    $data = $action->handle($dto);
    $count = count($data);

    expect($count)->toBeGreaterThan(0);
});

test('search returns NO data', function () {
    $repository = new \App\Repositories\SearchRepository;
    $action = new \App\Actions\Search($repository);
    $dto = new \App\DataTransferObjects\SearchDto('adsadsadsa', 0, 'asc');
    $data = $action->handle($dto);
    $count = count($data);

    expect($count)->toBe(0);
});
