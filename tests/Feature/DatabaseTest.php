<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

describe('database', function () {
    test('can read', function () {
        $tables = DB::table('Customers')->get();
        expect($tables instanceof Collection)->toBeTrue();
    });
});
