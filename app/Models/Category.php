<?php

namespace App\Models;

class Category extends NorthwindModel
{
    protected $primaryKey = 'CategoryID';
    protected $table = 'Categories';
    protected $fillable =
        [
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

    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryID', 'CategoryID');
    }
}
