<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $order = $this->route('order');

        if (!is_null($order->RequiredDate)) {
            abort(403, 'Can\'t modify an order that has already been committed.');
        }

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
            'CustomerID' => 'string|exists:customers,CustomerID',
            'EmployeeID' => 'integer|exists:employees,EmployeeID',
            'ShipName' => 'nullable|string',
            'ShipAddress' => 'nullable|string',
            'ShipCity' => 'nullable|string',
            'ShipRegion' => 'nullable|string',
            'ShipPostalCode' => 'nullable|string',
            'ShipCountry' => 'nullable|string',
            'Products' => 'array',
            'Products.*.ProductID' => [
                'required_with:Products',
                'integer',
                'distinct',
                'exists:products,ProductID',
                Rule::exists('products', 'ProductID')->where(fn($q) => $q->where('Discontinued', false)),
            ],
            'Products.*.Quantity' => 'required_with:Details|integer|min:1',
            'Products.*.Discount' => 'required_with:Details|numeric',
        ];
    }

    public function messages()
    {
        return [
            'Products.*.ProductID.distinct' => 'Each product may only appear once in the order.',
            'Products.*.ProductID.exists' => 'The selected product (:input) does not exist.',
            'Products.*.ProductID.Rule::exists' => 'The selected product (:input) is discontinued.',
        ];
    }
}
