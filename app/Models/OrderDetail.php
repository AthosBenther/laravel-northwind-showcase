<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends NorthwindModel
{
    protected $primaryKey = 'OrderID' ;
    protected $fillable = 
        [
    "OrderID",
    "ProductID",
    "UnitPrice",
    "Quantity",
    "Discount"
]
    ;
}
