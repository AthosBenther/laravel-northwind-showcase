<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'ProductID' => 'prohibited',
            'ProductName' => 'string',
            'SupplierID' => 'nullable|integer',
            'CategoryID' => 'nullable|integer',
            'QuantityPerUnit' => 'nullable|string',
            'UnitPrice' => 'nullable',
            'UnitsInStock' => 'nullable|integer',
            'UnitsOnOrder' => 'nullable|integer',
            'ReorderLevel' => 'nullable|integer',
            'Discontinued' => 'string',
        ];
    }
}
