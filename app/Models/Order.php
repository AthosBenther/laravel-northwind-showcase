<?php

namespace App\Models;

class Order extends NorthwindModel
{
    protected $primaryKey = 'OrderID';
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
            'Quantity' => 'integer',
            'Discount' => 'float',
        ]
    ;
}
