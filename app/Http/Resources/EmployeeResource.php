<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'EmployeeID' => $this->EmployeeID,
            'LastName' => $this->LastName,
            'FirstName' => $this->FirstName,
            'Title' => $this->Title,
            'TitleOfCourtesy' => $this->TitleOfCourtesy,
            'BirthDate' => $this->BirthDate,
            'HireDate' => $this->HireDate,
            'Address' => $this->Address,
            'City' => $this->City,
            'Region' => $this->Region,
            'PostalCode' => $this->PostalCode,
            'Country' => $this->Country,
            'HomePhone' => $this->HomePhone,
            'Extension' => $this->Extension,
            'Photo' => $this->Photo,
            'Notes' => $this->Notes,
            'PhotoPath' => $this->PhotoPath,

            // include a *simplified* version of the manager to avoid recursion
            'ReportsTo' => $this->reportsTo ? [
                'EmployeeID' => $this->reportsTo->EmployeeID,
                'FirstName' => $this->reportsTo->FirstName,
                'LastName' => $this->reportsTo->LastName,
                'Title' => $this->reportsTo->Title,
            ] : null,
        ];
    }
}
