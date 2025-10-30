<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Shipper', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/shippers');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'CompanyName' =>  fake()->sentence(),
            'Phone' =>  fake()->sentence(),
        ];

        $response = post('api/shippers', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['Shipper'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/shippers/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'CompanyName' =>  fake()->sentence(),
            'Phone' =>  fake()->sentence(),
        ];

        $response = put("api/shippers/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/shippers/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
