<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'CustomerID' => 'required|string|exists:customers,CustomerID',
            'EmployeeID' => 'required|integer|exists:employees,EmployeeID',
            'ShipName' => 'nullable|string',
            'ShipAddress' => 'nullable|string',
            'ShipCity' => 'nullable|string',
            'ShipRegion' => 'nullable|string',
            'ShipPostalCode' => 'nullable|string',
            'ShipCountry' => 'nullable|string',
        ];
    }
}
