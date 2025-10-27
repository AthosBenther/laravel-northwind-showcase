<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shipper\Index;
use App\Http\Requests\Shipper\Store;
use App\Http\Requests\Shipper\Update;
use App\Models\Shipper;

class ShipperController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Shipper::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $model = Shipper::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipper $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Shipper $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipper $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
