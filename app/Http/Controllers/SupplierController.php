<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\SupplierCollection;
use App\Http\Resources\SupplierResource;
use App\Http\Requests\Supplier\Index;
use App\Http\Requests\Supplier\Store;
use App\Http\Requests\Supplier\Update;
use App\Models\Supplier;

class SupplierController extends NorthwindController
{
    /**
     * Lists the Supplier resources.
     */
    public function index(Index $request): SupplierCollection
    {
        return new SupplierCollection(Supplier::paginate($request->per_page ?? 5));
    }

    /**
     * Creates a new Supplier.
     */
    public function store(Store $request): SupplierResource
    {
        $supplier = Supplier::create($request->validated());

        return new  SupplierResource($supplier);
    }

    /**
     * Display the specified Supplier.
     */
    public function show(Supplier $supplier): SupplierResource
    {
        return new  SupplierResource($supplier);
    }

    /**
     * Update the specified Supplier.
     */
    public function update(Update $request, Supplier $supplier): SupplierResource
    {
        $supplier->update($request->validated());

        return new SupplierResource($supplier);
    }

    /**
     * Destroys the specified Supplier.
     */
    public function destroy(Supplier $supplier): Response
    {
        $supplier->delete();

        return response()->noContent();
    }
}
