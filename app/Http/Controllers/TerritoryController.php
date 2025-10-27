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
        $model = Territory::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Territory $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Territory $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Territory $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
