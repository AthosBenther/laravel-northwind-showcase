<?php

namespace App\Http\Requests\Customer;

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
            'CompanyName' => 'required|string|min:3|max:125',
            'ContactName' => 'required|string|min:3|max:125',
            'ContactTitle' => 'required|string|min:3|max:125',
            'Address' => 'required|string|min:3|max:125',
            'City' => 'required|string|min:3|max:125',
            'Region' => 'nullable|string|min:3|max:125',
            'PostalCode' => 'required|string|min:3|max:125',
            'Country' => 'required|string|min:3|max:125',
            'Phone' => 'required|string|min:10',
            'Fax' => 'string|min:10',
        ];
    }
}
