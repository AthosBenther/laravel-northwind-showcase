<?php

namespace App\Models;

class Shipper extends NorthwindModel
{
    protected $primaryKey = 'ShipperID' ;
    protected $table = 'Shippers';
    protected $fillable =
        [
            'ShipperID',
            'CompanyName',
            'Phone',
        ]
    ;

    protected $casts =
        [
        ]
    ;
}
