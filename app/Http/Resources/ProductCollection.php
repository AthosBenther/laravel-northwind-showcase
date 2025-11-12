<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return $this->collection->map(function ($item) {
            return [
                'ProductID' => $item->ProductID,
                'ProductName' => $item->ProductName,
                'QuantityPerUnit' => $item->QuantityPerUnit,
                'UnitPrice' => $item->UnitPrice,
                'UnitsInStock' => $item->UnitsInStock,
                'UnitsOnOrder' => $item->UnitsOnOrder,
                // 'ReorderLevel' => $item->ReorderLevel,
                'Discontinued' => $item->Discontinued,
                'Category' => $item->category ? [
                    'CategoryID' => $item->category->CategoryID,
                    'CategoryName' => $item->category->CategoryName,
                    // 'Description' => $item->category->Description,
                ] : null,
                'Supplier' => $item->supplier ? [
                    'SupplierID' => $item->supplier->SupplierID,
                    'CompanyName' => $item->supplier->CompanyName,
                    // 'ContactName' => $item->supplier->ContactName,
                    // 'ContactTitle' => $item->supplier->ContactTitle,
                    // 'Address' => $item->supplier->Address,
                    // 'City' => $item->supplier->City,
                    // 'Region' => $item->supplier->Region,
                    // 'PostalCode' => $item->supplier->PostalCode,
                    // 'Country' => $item->supplier->Country,
                    // 'Phone' => $item->supplier->Phone,
                    // 'Fax' => $item->supplier->Fax,
                    // 'HomePage' => $item->supplier->HomePage,
                ] : null,
            ];
        });
    }
}
