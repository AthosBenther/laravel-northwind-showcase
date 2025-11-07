<?php

namespace App\Http\Requests\Category;

use Dedoc\Scramble\Attributes\SchemaName;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Update Category Request
 * 
 * Description
 * 
 */
#[SchemaName("Update Category Request")]
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
            'CategoryName' => 'string',
            'Description' => 'nullable|string',
            'Picture' => [
                'nullable',
                'file',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:2048',
            ]
        ];
    }
}
