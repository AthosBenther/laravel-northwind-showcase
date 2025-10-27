<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends NorthwindModel
{
    protected $primaryKey = 'SupplierID' ;
    protected $fillable = 
        [
    "SupplierID",
    "CompanyName",
    "ContactName",
    "ContactTitle",
    "Address",
    "City",
    "Region",
    "PostalCode",
    "Country",
    "Phone",
    "Fax",
    "HomePage"
]
    ;
}
