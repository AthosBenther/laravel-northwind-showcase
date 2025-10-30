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
        $shipper = Shipper::create($request->validated());

        return $shipper;
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipper $shipper)
    {
        return $shipper;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Shipper $shipper)
    {
        $shipper->update($request->validated());

        return $shipper;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipper $shipper)
    {
        $shipper->delete();

        return response()->noContent();
    }
}
