<?php

namespace App\Models;

use Illuminate\Support\Str;

class Customer extends NorthwindModel
{
    // Has to be declared as Northwind doesnt use 'id' by default
    protected $primaryKey = 'CustomerID';

    // Customer keys are user defined strings
    protected $keyType = 'string';

    // Customer keys are user defined strings by default, so no auto-increment...
    public $incrementing = false;

    protected $fillable = [
        'CompanyName',
        'ContactName',
        'ContactTitle',
        'Address',
        'City',
        'Region',
        'PostalCode',
        'Country',
        'Phone',
        'Fax',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
