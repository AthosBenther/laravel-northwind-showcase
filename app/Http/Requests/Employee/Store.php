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
            'LastName' => 'required|string|min:2',
            'FirstName' => 'required|string|min:2',
            'Title' => 'string|min:2',
            'TitleOfCourtesy' => 'string|min:2',
            'BirthDate' => 'required|date',
            'HireDate' => 'required|date',
            'Address' => 'string|min:2',
            'City' => 'string|min:2',
            'Region' => 'string|min:2',
            'PostalCode' => 'string|min:2',
            'Country' => 'string|min:2',
            'HomePhone' => 'required|string|min:2',
            'Extension' => 'string',
            'Photo' => [
                'nullable',
                'file',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:2048',
            ],
            'Notes' => 'string',
            'ReportsTo' => [
                'nullable',
                'integer',
                'exists:Employees,EmployeeID',
            ],
        ];
    }
}
