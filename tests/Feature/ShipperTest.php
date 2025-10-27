<?php

use App\Models\Shipper;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Shipper', function () {
    test('can index', function () {
        $response = get('api/shippers');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
  'ShipperID' => 'TESTDATA',
  'CompanyName' => 'TESTDATA',
  'Phone' => 'TESTDATA',
];

        $response = post('api/shippers', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/shippers/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
  'ShipperID' => 'TESTDATA',
  'CompanyName' => 'TESTDATA',
  'Phone' => 'TESTDATA',
];

        $response = put("api/shippers/$id", $testPayload, [
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

        $response = delete("api/shippers/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
