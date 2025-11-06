<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\TerritoryCollection;
use App\Http\Resources\TerritoryResource;
use App\Http\Requests\Territory\Index;
use App\Http\Requests\Territory\Store;
use App\Http\Requests\Territory\Update;
use App\Models\Territory;

class TerritoryController extends NorthwindController
{
    /**
     * Lists the Territory resources.
     */
    public function index(Index $request): TerritoryCollection
    {
        return new TerritoryCollection(Territory::paginate($request->per_page ?? 5));
    }

    /**
     * Creates a new Territory.
     */
    public function store(Store $request): TerritoryResource
    {
        $territory = Territory::create($request->validated());

        return new  TerritoryResource($territory);
    }

    /**
     * Display the specified Territory.
     */
    public function show(Territory $territory): TerritoryResource
    {
        return new  TerritoryResource($territory);
    }

    /**
     * Update the specified Territory.
     */
    public function update(Update $request, Territory $territory): TerritoryResource
    {
        $territory->update($request->validated());

        return new TerritoryResource($territory);
    }

    /**
     * Destroys the specified Territory.
     */
    public function destroy(Territory $territory): Response
    {
        $territory->delete();

        return response()->noContent();
    }
}
