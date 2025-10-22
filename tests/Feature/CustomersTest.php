<?php

use App\Models\Customer;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Customer', function () {
    test('can index', function () {
        $response = get('api/customers');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $data = [
            'CustomerID' => "TESTCUST",
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

        expect($responseData)->toBe($data);
    });

    test('can read', function () {
        $id = "TESTCUST";
        $response = get("api/customers/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = "TESTCUST";
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

        $response = put("api/customers/$id", $data, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect($responseData)->toBe([
            'CustomerID' => 'TESTCUST',
            ...$data
        ]);
    });

    test('can delete', function () {
        $id = "TESTCUST";

        $response = delete("api/customers/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
