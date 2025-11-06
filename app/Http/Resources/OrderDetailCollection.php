<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailCollection extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource->map(function ($item) {
            return [
                'ProductID' => $item->ProductID,
                'ProductName' => $item->ProductName,
                'Quantity' => $item->pivot->Quantity,
                'UnitPrice' => $item->pivot->UnitPrice,
                'Discount' => $item->pivot->Discount,
                'Total' => $item->pivot->Quantity * $item->pivot->UnitPrice * (1 - $item->pivot->Discount),
            ];
        })->toArray();
    }
}
