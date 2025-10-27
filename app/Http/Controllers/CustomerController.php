<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\Index;
use App\Http\Requests\Customer\Store;
use App\Http\Requests\Customer\Update;
use App\Models\Customer;

class CustomerController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Customer::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $customer = Customer::create($request->validated());

        return $customer;
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Customer $customer)
    {
        $customer->update($request->validated());

        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}
