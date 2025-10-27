<?php

namespace App\Http\Requests\Employee;

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
  'LastName' => 'required|string',
  'FirstName' => 'required|string',
  'Title' => 'required|string',
  'TitleOfCourtesy' => 'required|string',
  'BirthDate' => 'required|date',
  'HireDate' => 'required|date',
  'Address' => 'required|string',
  'City' => 'required|string',
  'Region' => 'required|string',
  'PostalCode' => 'required|string',
  'Country' => 'required|string',
  'HomePhone' => 'required|string',
  'Extension' => 'required|string',
  'Photo' => 'required',
  'Notes' => 'required|string',
  'ReportsTo' => 'required|integer',
  'PhotoPath' => 'required|string',
];
    }
}
