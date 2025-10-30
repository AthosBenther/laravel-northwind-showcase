<?php

namespace App\Models;

class OrderDetail extends NorthwindModel
{
    protected $primaryKey = 'OrderID' ;
    protected $table = 'Order Details';
    protected $fillable =
        [
            'OrderID',
            'ProductID',
            'UnitPrice',
            'Quantity',
            'Discount',
        ]
    ;

    protected $casts =
        [
            'ProductID' => 'integer',
            'Quantity' => 'integer',
            'Discount' => 'float',
        ]
    ;
}
