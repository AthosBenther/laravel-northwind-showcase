<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'LastName' => 'string|min:2',
            'FirstName' => 'string|min:2',
            'Title' => 'string|min:2',
            'TitleOfCourtesy' => 'string|min:2',
            'BirthDate' => 'date',
            'HireDate' => 'date',
            'Address' => 'string|min:2',
            'City' => 'string|min:2',
            'Region' => 'string|min:2',
            'PostalCode' => 'string|min:2',
            'Country' => 'string|min:2',
            'HomePhone' => 'string|min:2',
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
                Rule::notIn([$this->route('employee')->EmployeeID])
            ],
        ];
    }

    public function messages()
    {
        return [
            'ReportsTo.not_in' => 'An employee cannot report to themselves.',
        ];
    }
}
