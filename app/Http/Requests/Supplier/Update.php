<?php

namespace App\Http\Requests\Supplier;

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
            'SupplierID' => 'prohibited',
            'CompanyName' => 'string',
            'ContactName' => 'nullable|string',
            'ContactTitle' => 'nullable|string',
            'Address' => 'nullable|string',
            'City' => 'nullable|string',
            'Region' => 'nullable|string',
            'PostalCode' => 'nullable|string',
            'Country' => 'nullable|string',
            'Phone' => 'nullable|string',
            'Fax' => 'nullable|string',
            'HomePage' => 'nullable|string',
        ];
    }
}
