<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     
     */
    public function toArray(Request $request): array
    {
        return [
            'ProductID' => $this->ProductID,
            'ProductName' => $this->ProductName,
            'QuantityPerUnit' => $this->QuantityPerUnit,
            'UnitPrice' => $this->UnitPrice,
            'UnitsInStock' => $this->UnitsInStock,
            'UnitsOnOrder' => $this->UnitsOnOrder,
            'ReorderLevel' => $this->ReorderLevel,
            'Discontinued' => $this->Discontinued,
            'Category' => $this->category ? [
                'CategoryID' => $this->category->CategoryID,
                'CategoryName' => $this->category->CategoryName,
                'Description' => $this->category->Description,
            ] : null,
            'Supplier' => $this->supplier ? [
                'SupplierID' => $this->supplier->SupplierID,
                'CompanyName' => $this->supplier->CompanyName,
                'ContactName' => $this->supplier->ContactName,
                'ContactTitle' => $this->supplier->ContactTitle,
                // 'Address' => $this->supplier->Address,
                // 'City' => $this->supplier->City,
                // 'Region' => $this->supplier->Region,
                // 'PostalCode' => $this->supplier->PostalCode,
                // 'Country' => $this->supplier->Country,
                // 'Phone' => $this->supplier->Phone,
                // 'Fax' => $this->supplier->Fax,
                // 'HomePage' => $this->supplier->HomePage,
            ] : null,
        ];
    }
}
