<?php

use App\Models\Product;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Product', function () {
    test('can index', function () {
        $response = get('api/products');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
  'ProductID' => 'TESTDATA',
  'ProductName' => 'TESTDATA',
  'SupplierID' => 'TESTDATA',
  'CategoryID' => 'TESTDATA',
  'QuantityPerUnit' => 'TESTDATA',
  'UnitPrice' => 'TESTDATA',
  'UnitsInStock' => 'TESTDATA',
  'UnitsOnOrder' => 'TESTDATA',
  'ReorderLevel' => 'TESTDATA',
  'Discontinued' => 'TESTDATA',
];

        $response = post('api/products', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/products/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
  'ProductID' => 'TESTDATA',
  'ProductName' => 'TESTDATA',
  'SupplierID' => 'TESTDATA',
  'CategoryID' => 'TESTDATA',
  'QuantityPerUnit' => 'TESTDATA',
  'UnitPrice' => 'TESTDATA',
  'UnitsInStock' => 'TESTDATA',
  'UnitsOnOrder' => 'TESTDATA',
  'ReorderLevel' => 'TESTDATA',
  'Discontinued' => 'TESTDATA',
];

        $response = put("api/products/$id", $testPayload, [
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

        $response = delete("api/products/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
