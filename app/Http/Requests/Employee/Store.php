<?php

namespace App\Http\Requests\Employee;

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
            'EmployeeID' => 'prohibited',
            'LastName' => 'nullable|string',
            'FirstName' => 'nullable|string',
            'Title' => 'nullable|string',
            'TitleOfCourtesy' => 'nullable|string',
            'BirthDate' => 'nullable|date',
            'HireDate' => 'nullable|date',
            'Address' => 'nullable|string',
            'City' => 'nullable|string',
            'Region' => 'nullable|string',
            'PostalCode' => 'nullable|string',
            'Country' => 'nullable|string',
            'HomePhone' => 'nullable|string',
            'Extension' => 'nullable|string',
            'Photo' => 'nullable',
            'Notes' => 'nullable|string',
            'ReportsTo' => 'nullable|integer',
            'PhotoPath' => 'nullable|string',
        ];
    }
}
