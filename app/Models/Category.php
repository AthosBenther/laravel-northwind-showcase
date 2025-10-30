<?php

namespace App\Models;

class Category extends NorthwindModel
{
    protected $primaryKey = 'CategoryID' ;
    protected $table = 'Categories';
    protected $fillable =
        [
            'CategoryID',
            'CategoryName',
            'Description',
            'Picture',
        ]
    ;

    protected $casts =
        [
            'Picture' => 'App\\Casts\\BlobImageCast',
        ]
    ;
}
