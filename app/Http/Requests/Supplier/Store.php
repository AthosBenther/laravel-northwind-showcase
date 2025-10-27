<?php

namespace App\Http\Requests\Supplier;

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
  'CompanyName' => 'nullable|string',
  'ContactName' => 'required|string',
  'ContactTitle' => 'required|string',
  'Address' => 'required|string',
  'City' => 'required|string',
  'Region' => 'required|string',
  'PostalCode' => 'required|string',
  'Country' => 'required|string',
  'Phone' => 'required|string',
  'Fax' => 'required|string',
  'HomePage' => 'required|string',
];
    }
}
