<?php

use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};
use Illuminate\Http\UploadedFile;

$testingId = null;

describe('Employee', function () use (&$testingId) {
    test('can index', function () {
        $response = get('api/employees');

        $response->assertStatus(200);
    });

    test('can create', function () use (&$testingId) {
        $gender = fake()->boolean();
        $reportsToSomeone = fake()->boolean();
        $hasPhoto = fake()->boolean();

        $birth = fake()->dateTimeBetween('-60 years', '-20 years');
        $hire = fake()->dateTimeBetween($birth->modify('+18 years'), 'now');

        $testStaticPayload = [
            'LastName' => fake()->lastName($gender),
            'FirstName' => fake()->firstName($gender),
            'Title' => fake()->title($gender),
            'TitleOfCourtesy' => fake()->title($gender),
            'BirthDate' => $birth->format('Y-m-d\\TH:i:s.u\\Z'),
            'HireDate' => $hire->format('Y-m-d\\TH:i:s.u\\Z'),
            'Address' => fake()->address(),
            'City' => fake()->city(),
            'Region' => fake()->sentence(),
            'PostalCode' => fake()->postcode(),
            'Country' => fake()->country(),
            'HomePhone' => fake()->phoneNumber(),
            'Extension' => fake()->numberBetween(1000, 99999) . "",
            'Notes' => fake()->paragraph(),
        ];

        $testPayload = [
            ...$testStaticPayload,
            'ReportsTo' => null
        ];

        if ($hasPhoto) {
            Storage::fake('public');

            $file = UploadedFile::fake()->image('test.png');
            $testPayload['Photo'] = $file;
        }

        if ($reportsToSomeone)
            $testPayload['ReportsTo'] = fake()->numberBetween(1, 9);


        $response = post('api/employees', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testStaticPayload));

        expect($responseData)
            ->toHaveKey('Photo');

        if ($hasPhoto)
            expect($responseData['Photo'])->toStartWith('data:image/png;base64,');

        expect($responseData)
            ->toHaveKey('ReportsTo');

        if ($reportsToSomeone)
            expect($responseData['ReportsTo'])
                ->toHaveKey('EmployeeID');

        $testingId = $responseData['EmployeeID'];
    });

    test('can read', function () use (&$testingId) {
        $response = get("api/employees/$testingId");

        $response->assertStatus(200);
        $responseData = $response->json();
        expect($responseData)->not()->toBe([]);
    })->depends('can create');

    test('can update', function () use (&$testingId) {
        $gender = fake()->boolean();
        $reportsToSomeone = fake()->boolean();
        $hasPhoto = fake()->boolean();


        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.png');

        $testStaticPayload = [
            'LastName' => fake()->lastName($gender),
            'FirstName' => fake()->firstName($gender),
            'Title' => fake()->title($gender),
            'TitleOfCourtesy' => fake()->title($gender),
            'BirthDate' => fake()->dateTime()->format('Y-m-d\\TH:i:s.u\\Z'),
            'HireDate' => fake()->dateTime()->format('Y-m-d\\TH:i:s.u\\Z'),
            'Address' => fake()->address(),
            'City' => fake()->city(),
            'Region' => fake()->sentence(),
            'PostalCode' => fake()->postcode(),
            'Country' => fake()->country(),
            'HomePhone' => fake()->phoneNumber(),
            'Extension' => fake()->numberBetween(1000, 99999) . "",
            'Notes' => fake()->paragraph(),
        ];

        $testPayload = [
            ...$testStaticPayload,
            'ReportsTo' => null
        ];

        if ($hasPhoto) {
            Storage::fake('public');

            $file = UploadedFile::fake()->image('test.png');
            $testPayload['Photo'] = $file;
        }

        if ($reportsToSomeone)
            $testPayload['ReportsTo'] = fake()->numberBetween(1, 9);

        $response = put("api/employees/$testingId", $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = $response->json();

        expect(normalize_dates($responseData))->toMatchArray(normalize_dates($testStaticPayload));

        expect($responseData)
            ->toHaveKey('Photo');

        if ($hasPhoto)
            expect($responseData['Photo'])->toStartWith('data:image/png;base64,');

        expect($responseData)
            ->toHaveKey('ReportsTo');

        if ($reportsToSomeone)
            expect($responseData['ReportsTo'])
                ->toHaveKey('EmployeeID');

    })->depends('can create');

    test('can delete', function () use (&$testingId) {
        $response = delete("api/employees/$testingId", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    })->depends('can create');
});
