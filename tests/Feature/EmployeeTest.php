<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

$testingId = null;

describe('Employee', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/employees');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $testPayload = [
            'LastName' =>  fake()->sentence(),
            'FirstName' =>  fake()->sentence(),
            'Title' =>  fake()->sentence(),
            'TitleOfCourtesy' =>  fake()->sentence(),
            'BirthDate' =>  fake()->dateTime()->format('Y-m-d\\TH:i:s.u\\Z'),
            'HireDate' =>  fake()->dateTime()->format('Y-m-d\\TH:i:s.u\\Z'),
            'Address' =>  fake()->sentence(),
            'City' =>  fake()->sentence(),
            'Region' =>  fake()->sentence(),
            'PostalCode' =>  fake()->sentence(),
            'Country' =>  fake()->sentence(),
            'HomePhone' =>  fake()->sentence(),
            'Extension' =>  fake()->sentence(),
            'Notes' =>  fake()->sentence(),
            'PhotoPath' =>  fake()->sentence(),
        ];

        $response = post('api/employees', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
        $testingId = $responseData['Employee'.'ID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/employees/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    });

    test('can update', function () use (&$testingId) {
        $testPayload = [
            'LastName' =>  fake()->sentence(),
            'FirstName' =>  fake()->sentence(),
            'Title' =>  fake()->sentence(),
            'TitleOfCourtesy' =>  fake()->sentence(),
            'BirthDate' =>  fake()->dateTime()->format('Y-m-d\\TH:i:s.u\\Z'),
            'HireDate' =>  fake()->dateTime()->format('Y-m-d\\TH:i:s.u\\Z'),
            'Address' =>  fake()->sentence(),
            'City' =>  fake()->sentence(),
            'Region' =>  fake()->sentence(),
            'PostalCode' =>  fake()->sentence(),
            'Country' =>  fake()->sentence(),
            'HomePhone' =>  fake()->sentence(),
            'Extension' =>  fake()->sentence(),
            'Notes' =>  fake()->sentence(),
            'PhotoPath' =>  fake()->sentence(),
        ];

        $response = put("api/employees/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testPayload));
    });

    test('can delete', function () use (&$testingId) {
        $id = 'TESTPK';

        $response = delete("api/employees/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
