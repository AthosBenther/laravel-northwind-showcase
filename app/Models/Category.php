<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends NorthwindModel
{
    protected $primaryKey = 'CategoryID' ;
    protected $fillable = 
        [
    "CategoryID",
    "CategoryName",
    "Description",
    "Picture"
]
    ;
}
