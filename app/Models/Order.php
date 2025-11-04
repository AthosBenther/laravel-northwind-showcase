<?php

namespace App\Models;

class Order extends NorthwindModel
{
    protected $primaryKey = 'OrderID';
    protected $table = 'Orders';
    protected $fillable =
        [
            'OrderID',
            'CustomerID',
            'EmployeeID',
            'OrderDate',
            'RequiredDate',
            'ShippedDate',
            'ShipVia',
            'Freight',
            'ShipName',
            'ShipAddress',
            'ShipCity',
            'ShipRegion',
            'ShipPostalCode',
            'ShipCountry',
        ]
    ;

    protected $casts =
        [
            'OrderDate' => 'datetime',
            'RequiredDate' => 'datetime',
            'ShippedDate' => 'datetime',
        ]
    ;

    function Customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }
    function Employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID');
    }
    function Shipper()
    {
        return $this->belongsTo(Shipper::class, 'ShipVia');
    }
    function Details()
    {
        return $this->belongsToMany(Product::class, 'Order Details', 'OrderID', 'ProductID')
            ->withPivot('UnitPrice', 'Quantity', 'Discount');
    }

}