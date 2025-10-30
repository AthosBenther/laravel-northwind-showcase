<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Product', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/products');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'ProductName' =>  fake()->sentence(),
            'QuantityPerUnit' =>  fake()->sentence(),
            'UnitPrice' =>  fake()->randomNumber(),
            'UnitsInStock' =>  fake()->numberBetween(1, 1000),
            'UnitsOnOrder' =>  fake()->numberBetween(1, 1000),
            'ReorderLevel' =>  fake()->numberBetween(1, 1000),
            'Discontinued' =>  fake()->sentence(),
        ];

        $response = post('api/products', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['Product'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/products/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'ProductName' =>  fake()->sentence(),
            'QuantityPerUnit' =>  fake()->sentence(),
            'UnitPrice' =>  fake()->randomNumber(),
            'UnitsInStock' =>  fake()->numberBetween(1, 1000),
            'UnitsOnOrder' =>  fake()->numberBetween(1, 1000),
            'ReorderLevel' =>  fake()->numberBetween(1, 1000),
            'Discontinued' =>  fake()->sentence(),
        ];

        $response = put("api/products/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/products/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
