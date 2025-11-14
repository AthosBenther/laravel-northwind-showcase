<?php

use App\Models\Customer;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Customer', function () use (&$testingId) {

    test('can index', function () {
        $response = get('api/customers');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $data = [
            'CompanyName' => fake()->company(),
            'ContactName' => fake()->name(),
            'ContactTitle' => fake()->title(),
            'Address' => fake()->address(),
            'City' => fake()->city(),
            'Region' => fake()->boolean() ? fake()->sentence(3) : null,
            'PostalCode' => fake()->postcode(),
            'Country' => fake()->country(),
            'Phone' => fake()->phoneNumber(),
            'Fax' => fake()->phoneNumber()
        ];

        $response = post('api/customers', $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toMatchArray($data);

        $testingId = $responseData['CustomerID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/customers/$testingId");

        $response->assertStatus(200);
    });

    test('can update', function () use (&$testingId) {
        $data = [
            'CompanyName' => fake()->company(),
            'ContactName' => fake()->name(),
            'ContactTitle' => fake()->title(),
            'Address' => fake()->address(),
            'City' => fake()->city(),
            'Region' => fake()->boolean() ? fake()->sentence(3) : null,
            'PostalCode' => fake()->postcode(),
            'Country' => fake()->country(),
            'Phone' => fake()->phoneNumber(),
            'Fax' => fake()->phoneNumber()
        ];

        $response = put("api/customers/$testingId", $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect($responseData)->toMatchArray([
            ...$data
        ]);
    });

    test('can delete', function () use (&$testingId) {
        $response = delete("api/customers/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
