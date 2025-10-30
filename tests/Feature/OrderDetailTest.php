<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('OrderDetail', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/order-details');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'UnitPrice' =>  fake()->randomNumber(),
            'Quantity' =>  fake()->numberBetween(1, 1000),
            'Discount' =>  fake()->randomNumber(),
        ];

        $response = post('api/order-details', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['OrderDetail'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/order-details/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'UnitPrice' =>  fake()->randomNumber(),
            'Quantity' =>  fake()->numberBetween(1, 1000),
            'Discount' =>  fake()->randomNumber(),
        ];

        $response = put("api/order-details/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/order-details/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
})->skip();
