<?php

use App\Models\Employee;
use function Pest\Laravel\{delete, get, post};
use function Pest\Laravel\{put};

describe('Employee', function () {
    test('can index', function () {
        $response = get('api/employees');

        $response->assertStatus(200);
    });

    test('can create', function () {
        $testPayload = [
  'EmployeeID' => 'TESTDATA',
  'LastName' => 'TESTDATA',
  'FirstName' => 'TESTDATA',
  'Title' => 'TESTDATA',
  'TitleOfCourtesy' => 'TESTDATA',
  'BirthDate' => 'TESTDATA',
  'HireDate' => 'TESTDATA',
  'Address' => 'TESTDATA',
  'City' => 'TESTDATA',
  'Region' => 'TESTDATA',
  'PostalCode' => 'TESTDATA',
  'Country' => 'TESTDATA',
  'HomePhone' => 'TESTDATA',
  'Extension' => 'TESTDATA',
  'Photo' => 'TESTDATA',
  'Notes' => 'TESTDATA',
  'ReportsTo' => 'TESTDATA',
  'PhotoPath' => 'TESTDATA',
];

        $response = post('api/employees', $testPayload, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(201);

        $responseData = $response->json();

        expect($responseData)->toBe($testPayload);
    });

    test('can read', function () {
        $id = 'TESTPK';
        $response = get("api/employees/$id");

        $response->assertStatus(200);
    });

    test('can update', function () {
        $id = 'TESTPK';
        $testPayload = [
  'EmployeeID' => 'TESTDATA',
  'LastName' => 'TESTDATA',
  'FirstName' => 'TESTDATA',
  'Title' => 'TESTDATA',
  'TitleOfCourtesy' => 'TESTDATA',
  'BirthDate' => 'TESTDATA',
  'HireDate' => 'TESTDATA',
  'Address' => 'TESTDATA',
  'City' => 'TESTDATA',
  'Region' => 'TESTDATA',
  'PostalCode' => 'TESTDATA',
  'Country' => 'TESTDATA',
  'HomePhone' => 'TESTDATA',
  'Extension' => 'TESTDATA',
  'Photo' => 'TESTDATA',
  'Notes' => 'TESTDATA',
  'ReportsTo' => 'TESTDATA',
  'PhotoPath' => 'TESTDATA',
];

        $response = put("api/employees/$id", $testPayload, [
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

        $response = delete("api/employees/$id", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(204);
    });
});
