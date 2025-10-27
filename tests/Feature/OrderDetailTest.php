<?php

use App\Models\OrderDetail;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('OrderDetail', function () {
    test('can index', function () {
        $response = get('api/order-details');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
  'OrderID' => 'TESTDATA',
  'ProductID' => 'TESTDATA',
  'UnitPrice' => 'TESTDATA',
  'Quantity' => 'TESTDATA',
  'Discount' => 'TESTDATA',
];

        $response = post('api/order-details', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/order-details/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
  'OrderID' => 'TESTDATA',
  'ProductID' => 'TESTDATA',
  'UnitPrice' => 'TESTDATA',
  'Quantity' => 'TESTDATA',
  'Discount' => 'TESTDATA',
];

        $response = put("api/order-details/$id", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect($responseData)->toBe([
            'CustomerID' => 'TESTCUST',
            ...$testPayload
        ]);
    });

    test('can delete', function () {
        $id = 'TESTPK';

        $response = delete("api/order-details/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
