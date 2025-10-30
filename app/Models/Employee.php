<?php

namespace App\Models;

class Employee extends NorthwindModel
{
    protected $primaryKey = 'EmployeeID' ;
    protected $table = 'Employees';
    protected $fillable =
        [
            'EmployeeID',
            'LastName',
            'FirstName',
            'Title',
            'TitleOfCourtesy',
            'BirthDate',
            'HireDate',
            'Address',
            'City',
            'Region',
            'PostalCode',
            'Country',
            'HomePhone',
            'Extension',
            'Photo',
            'Notes',
            'ReportsTo',
            'PhotoPath',
        ]
    ;

    protected $casts =
        [
            'BirthDate' => 'datetime',
            'HireDate' => 'datetime',
            'Photo' => 'App\\Casts\\BlobImageCast',
            'ReportsTo' => 'integer',
        ]
    ;
}
