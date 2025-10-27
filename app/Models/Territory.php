<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Territory extends NorthwindModel
{
    protected $primaryKey = 'TerritoryID' ;
    protected $fillable = 
        [
    "TerritoryID",
    "TerritoryDescription",
    "RegionID"
]
    ;
}
