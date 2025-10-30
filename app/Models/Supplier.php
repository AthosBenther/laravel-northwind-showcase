<?php

namespace App\Models;

class Supplier extends NorthwindModel
{
    protected $primaryKey = 'SupplierID' ;
    protected $table = 'Suppliers';
    protected $fillable =
        [
            'SupplierID',
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
            'HomePage',
        ]
    ;

    protected $casts =
        [
        ]
    ;
}
