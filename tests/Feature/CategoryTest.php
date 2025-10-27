<?php

use App\Models\Category;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Category', function () {
    test('can index', function () {
        $response = get('api/categories');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
            'CategoryID' => 'TESTDATA',
            'CategoryName' => fake()->word(),
            'Description' => fake()->sentence(),
            'Picture' => '',
        ];

        $response = post('api/categories', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/categories/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
            'CategoryName' => fake()->word(),
            'Description' => fake()->sentence(),
            'Picture' => '',
        ];

        $response = put("api/categories/$id", $testPayload, [
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

        $response = delete("api/categories/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
