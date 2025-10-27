<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends NorthwindModel
{
    protected $primaryKey = 'ProductID' ;
    protected $fillable = 
        [
    "ProductID",
    "ProductName",
    "SupplierID",
    "CategoryID",
    "QuantityPerUnit",
    "UnitPrice",
    "UnitsInStock",
    "UnitsOnOrder",
    "ReorderLevel",
    "Discontinued"
]
    ;
}
