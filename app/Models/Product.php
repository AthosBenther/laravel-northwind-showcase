<?php

namespace App\Models;

class Product extends NorthwindModel
{
    protected $primaryKey = 'ProductID' ;
    protected $table = 'Products';
    protected $fillable =
        [
            'ProductID',
            'ProductName',
            'SupplierID',
            'CategoryID',
            'QuantityPerUnit',
            'UnitPrice',
            'UnitsInStock',
            'UnitsOnOrder',
            'ReorderLevel',
            'Discontinued',
        ]
    ;

    protected $casts =
        [
            'SupplierID' => 'integer',
            'CategoryID' => 'integer',
            'UnitsInStock' => 'integer',
            'UnitsOnOrder' => 'integer',
            'ReorderLevel' => 'integer',
        ]
    ;
}
