<?php

namespace App\Models;

class Product extends NorthwindModel
{
    protected $primaryKey = 'ProductID';
    protected $table = 'Products';
    protected $fillable = [
        'ProductName',
        'SupplierID',
        'CategoryID',
        'QuantityPerUnit',
        'UnitPrice',
        'UnitsInStock',
        'UnitsOnOrder',
        'ReorderLevel',
        'Discontinued',
    ];

    protected $casts = [
        'SupplierID' => 'integer',
        'CategoryID' => 'integer',
        'UnitPrice' => 'float',
        'UnitsInStock' => 'integer',
        'UnitsOnOrder' => 'integer',
        'ReorderLevel' => 'integer',
        'Discontinued' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'SupplierID');
    }
}
