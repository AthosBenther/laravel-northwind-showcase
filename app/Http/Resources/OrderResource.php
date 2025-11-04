<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'OrderID' => $this->OrderID,
            'OrderDate' => $this->OrderDate,
            'RequiredDate' => $this->RequiredDate,
            'ShippedDate' => $this->ShippedDate,
            'Freight' => $this->Freight,
            'ShipName' => $this->ShipName,
            'ShipAddress' => $this->ShipAddress,
            'ShipCity' => $this->ShipCity,
            'ShipRegion' => $this->ShipRegion,
            'ShipPostalCode' => $this->ShipPostalCode,
            'ShipCountry' => $this->ShipCountry,
            'Customer' => $this->customer ? [
                'CustomerID' => $this->CustomerID,
                'CompanyName' => $this->customer->CompanyName,
                'ContactName' => $this->customer->ContactName,
                'ContactTitle' => $this->customer->ContactTitle,
            ] : null,
            'Employee' => $this->customer ? [
                'EmployeeID' => $this->EmployeeID,
                'FirstName' => $this->employee?->FirstName,
                'LastName' => $this->employee?->LastName,
                'Title' => $this->employee?->Title,
            ] : null,
            'ShipVia' => $this->shipper,
            'ProductsTotal' => $this->details->sum(function ($item) {
                return $item->pivot->Quantity * $item->pivot->UnitPrice * (1 - $item->pivot->Discount);
            }),
            'TotalWithFreight' => $this->details->sum(function ($item) {
                return $item->pivot->Quantity * $item->pivot->UnitPrice * (1 - $item->pivot->Discount);
            }) + $this->Freight,
            'Details' => new OrderDetailCollection($this->details->toResourceCollection()),
        ];
    }
}
