<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\Index;
use App\Http\Requests\Supplier\Store;
use App\Http\Requests\Supplier\Update;
use App\Models\Supplier;

class SupplierController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Supplier::paginate($request->per_page ?? 5)->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $supplier = Supplier::create($request->validated());

        return $supplier;
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return $supplier->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->noContent();
    }
}
