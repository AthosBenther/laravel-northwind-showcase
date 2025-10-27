<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipper extends NorthwindModel
{
    protected $primaryKey = 'ShipperID' ;
    protected $fillable = 
        [
    "ShipperID",
    "CompanyName",
    "Phone"
]
    ;
}
