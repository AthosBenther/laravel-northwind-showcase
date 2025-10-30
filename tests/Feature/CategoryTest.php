<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Category', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/categories');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'CategoryName' =>  fake()->sentence(),
            'Description' =>  fake()->sentence(),
        ];

        $response = post('api/categories', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['Category'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/categories/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'CategoryName' =>  fake()->sentence(),
            'Description' =>  fake()->sentence(),
        ];

        $response = put("api/categories/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/categories/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
