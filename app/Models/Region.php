<?php

namespace App\Models;

class Region extends NorthwindModel
{
    protected $primaryKey = 'RegionID';
    protected $table = 'Regions';
    protected $fillable = [
        'RegionID',
        'RegionDescription'
    ];
}
