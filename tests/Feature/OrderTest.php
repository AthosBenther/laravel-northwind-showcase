<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};
use App\Models\Product;

$testingId = null;

describe('Order', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/orders');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $randomPayload = [
            "ShipName" => fake()->name(),
            "ShipAddress" => fake()->address(),
            "ShipCity" => fake()->city(),
            "ShipRegion" => fake()->word(),
            "ShipPostalCode" => fake()->postcode(),
            "ShipCountry" => fake()->country(),
        ];

        $testPayload = [
            ...$randomPayload,
            "CustomerID" => "VINET",
            "EmployeeID" => 5,
        ];

        $response = post('api/orders', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($randomPayload));
        $testingId = $responseData['OrderID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/orders/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {


        $testingProducts = Product::select('ProductID', 'UnitsInStock as Quantity')
            ->where('Discontinued', false)
            ->where('UnitsInStock', '>', 0)
            ->inRandomOrder()
            ->limit(5)
            ->get()
            ->sortBy('ProductID')
            ->values()
            ->toArray();

        $testPayload = [
            "ShipName" => fake()->name(),
            "ShipAddress" => fake()->address(),
            "ShipCity" => fake()->city(),
            "ShipRegion" => fake()->word(),
            "ShipPostalCode" => fake()->postcode(),
            "ShipCountry" => fake()->country()
        ];

        $requestPayload = [
            ...$testPayload,
            "Details" => $testingProducts
        ];

        $response = put("api/orders/$testingId", $requestPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect($responseData)->toMatchArray($requestPayload);
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/orders/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
