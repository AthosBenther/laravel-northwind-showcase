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
        return Supplier::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $model = Supplier::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Supplier $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
