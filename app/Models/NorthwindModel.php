<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Northwind Base Model. Declares all the fixes for its quirks in order to work in Laravel
 */
class NorthwindModel extends Model
{
    // //Northwind has no timestamps
    public $timestamps = false;

    /**
     * Get the table associated with the model in PascalCase
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table ?? Str::pascal(Str::pluralStudly(class_basename($this)));
    }
}
