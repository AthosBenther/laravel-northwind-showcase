<?php

namespace App\Models;

class Territory extends NorthwindModel
{
    protected $primaryKey = 'TerritoryID' ;
    protected $table = 'Territories';
    protected $fillable =
        [
            'TerritoryID',
            'TerritoryDescription',
            'RegionID',
        ]
    ;

    protected $casts =
        [
            'RegionID' => 'integer',
        ]
    ;

    public function region()
    {
        return $this->belongsTo(Region::class, 'RegionID');
    }
}
