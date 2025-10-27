<?php

use App\Models\Supplier;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Supplier', function () {
    test('can index', function () {
        $response = get('api/suppliers');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
  'SupplierID' => 'TESTDATA',
  'CompanyName' => 'TESTDATA',
  'ContactName' => 'TESTDATA',
  'ContactTitle' => 'TESTDATA',
  'Address' => 'TESTDATA',
  'City' => 'TESTDATA',
  'Region' => 'TESTDATA',
  'PostalCode' => 'TESTDATA',
  'Country' => 'TESTDATA',
  'Phone' => 'TESTDATA',
  'Fax' => 'TESTDATA',
  'HomePage' => 'TESTDATA',
];

        $response = post('api/suppliers', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/suppliers/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
  'SupplierID' => 'TESTDATA',
  'CompanyName' => 'TESTDATA',
  'ContactName' => 'TESTDATA',
  'ContactTitle' => 'TESTDATA',
  'Address' => 'TESTDATA',
  'City' => 'TESTDATA',
  'Region' => 'TESTDATA',
  'PostalCode' => 'TESTDATA',
  'Country' => 'TESTDATA',
  'Phone' => 'TESTDATA',
  'Fax' => 'TESTDATA',
  'HomePage' => 'TESTDATA',
];

        $response = put("api/suppliers/$id", $testPayload, [
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

        $response = delete("api/suppliers/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
