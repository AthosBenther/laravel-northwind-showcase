<?php

namespace App\Http\Controllers;

use App\Http\Requests\Territory\Index;
use App\Http\Requests\Territory\Store;
use App\Http\Requests\Territory\Update;
use App\Models\Territory;

class TerritoryController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Territory::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $territory = Territory::create($request->validated());

        return $territory;
    }

    /**
     * Display the specified resource.
     */
    public function show(Territory $territory)
    {
        return $territory;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Territory $territory)
    {
        $territory->update($request->validated());

        return $territory;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Territory $territory)
    {
        $territory->delete();

        return response()->noContent();
    }
}
