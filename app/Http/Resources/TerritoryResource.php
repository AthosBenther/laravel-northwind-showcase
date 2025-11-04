<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TerritoryResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'TerritoryID' => $this->TerritoryID,
            'TerritoryDescription' => $this->TerritoryDescription,
            'RegionID' => $this->RegionID,
            'Region' => $this->region,
        ];
    }
}
