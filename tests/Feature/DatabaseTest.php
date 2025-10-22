<?php

use Illuminate\Support\Facades\DB;

describe('Database', function () {
    test('can get PDO', function () {
        $tables = DB::connection()->getPdo();
        expect($tables instanceof \PDO)->toBeTrue();
    });
});
