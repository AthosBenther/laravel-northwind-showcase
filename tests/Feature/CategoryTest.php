<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};
use Illuminate\Http\UploadedFile;

$testingId = null;

describe('Category', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/categories');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.png');

        $testPayload = [
            'CategoryName' => fake()->sentence(),
            'Description' => fake()->sentence(),
            'Picture' => $file
        ];

        $response = post('api/categories', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertCreated();

        $responseData = $response->json();

        expect($responseData['CategoryName'])->toBe($testPayload['CategoryName']);
        expect($responseData['Description'])->toBe($testPayload['Description']);
        expect($responseData)
            ->toHaveKey('Picture')
            ->and($responseData['Picture'])->toStartWith('data:image/png;base64,');

        $testingId = $responseData['Category' . 'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/categories/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    })->depends('can create');

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'CategoryName' => fake()->sentence(),
            'Description' => fake()->sentence(),
        ];

        $response = put("api/categories/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    })->depends('can create');

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/categories/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    })->depends('can create');
})->only();
