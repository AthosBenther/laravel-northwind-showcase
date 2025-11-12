<?php

namespace App\Http\Requests\Customer;

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
            'CompanyName' => 'string|min:3|max:125',
            'ContactName' => 'string|min:3|max:125',
            'ContactTitle' => 'string|min:3|max:125',
            'Address' => 'string|min:3|max:125',
            'City' => 'string|min:3|max:125',
            'Region' => 'nullable|string|min:3|max:125',
            'PostalCode' => 'string|min:3|max:125',
            'Country' => 'string|min:3|max:125',
            'Phone' => 'string|min:10',
            'Fax' => 'nullable|string|min:10',
        ];
    }
}
