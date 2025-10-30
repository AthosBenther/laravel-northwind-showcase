<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Supplier', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/suppliers');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'CompanyName' =>  fake()->sentence(),
            'ContactName' =>  fake()->sentence(),
            'ContactTitle' =>  fake()->sentence(),
            'Address' =>  fake()->sentence(),
            'City' =>  fake()->sentence(),
            'Region' =>  fake()->sentence(),
            'PostalCode' =>  fake()->sentence(),
            'Country' =>  fake()->sentence(),
            'Phone' =>  fake()->sentence(),
            'Fax' =>  fake()->sentence(),
            'HomePage' =>  fake()->sentence(),
        ];

        $response = post('api/suppliers', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['Supplier'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/suppliers/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'CompanyName' =>  fake()->sentence(),
            'ContactName' =>  fake()->sentence(),
            'ContactTitle' =>  fake()->sentence(),
            'Address' =>  fake()->sentence(),
            'City' =>  fake()->sentence(),
            'Region' =>  fake()->sentence(),
            'PostalCode' =>  fake()->sentence(),
            'Country' =>  fake()->sentence(),
            'Phone' =>  fake()->sentence(),
            'Fax' =>  fake()->sentence(),
            'HomePage' =>  fake()->sentence(),
        ];

        $response = put("api/suppliers/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/suppliers/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
