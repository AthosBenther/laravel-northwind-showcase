<?php

namespace App\Models;

class Customer extends NorthwindModel
{
    // Has to be declared as Northwind doesnt use 'id' by default
    protected $primaryKey = 'CustomerID';

    // Customer keys are user defined strings
    protected $keyType = 'string';

    // Customer keys are user defined strings by default, so no auto-increment...
    public $incrementing = false;

    protected $fillable = [
        'CustomerID',
        'CompanyName',
        'ContactName',
        'ContactTitle',
        'Address',
        'City',
        'Region',
        'PostalCode',
        'Country',
        'Phone',
        'Fax',
    ];
}
