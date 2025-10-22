<?php

namespace App\Models;

class Customer extends NorthwindModel
{
    // Has to be declared as Northwind doesnt use 'id' by default
    protected $primaryKey = 'CustomerID';

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
