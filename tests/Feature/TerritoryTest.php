<?php

use App\Models\Territory;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Territory', function () {
    test('can index', function () {
        $response = get('api/territories');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
  'TerritoryID' => 'TESTDATA',
  'TerritoryDescription' => 'TESTDATA',
  'RegionID' => 'TESTDATA',
];

        $response = post('api/territories', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/territories/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
  'TerritoryID' => 'TESTDATA',
  'TerritoryDescription' => 'TESTDATA',
  'RegionID' => 'TESTDATA',
];

        $response = put("api/territories/$id", $testPayload, [
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

        $response = delete("api/territories/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
