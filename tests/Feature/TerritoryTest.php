<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Territory', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/territories');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'TerritoryDescription' =>  fake()->sentence(),
        ];

        $response = post('api/territories', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['Territory'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/territories/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'TerritoryDescription' =>  fake()->sentence(),
        ];

        $response = put("api/territories/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/territories/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
})->skip();
