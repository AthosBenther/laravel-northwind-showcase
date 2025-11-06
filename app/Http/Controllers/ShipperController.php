<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\ShipperCollection;
use App\Http\Resources\ShipperResource;
use App\Http\Requests\Shipper\Index;
use App\Http\Requests\Shipper\Store;
use App\Http\Requests\Shipper\Update;
use App\Models\Shipper;

class ShipperController extends NorthwindController
{
    /**
     * Lists the Shipper resources.
     */
    public function index(Index $request): ShipperCollection
    {
        return new ShipperCollection(Shipper::paginate($request->per_page ?? 5));
    }

    /**
     * Creates a new Shipper.
     */
    public function store(Store $request): ShipperResource
    {
        $shipper = Shipper::create($request->validated());

        return new  ShipperResource($shipper);
    }

    /**
     * Display the specified Shipper.
     */
    public function show(Shipper $shipper): ShipperResource
    {
        return new  ShipperResource($shipper);
    }

    /**
     * Update the specified Shipper.
     */
    public function update(Update $request, Shipper $shipper): ShipperResource
    {
        $shipper->update($request->validated());

        return new ShipperResource($shipper);
    }

    /**
     * Destroys the specified Shipper.
     */
    public function destroy(Shipper $shipper): Response
    {
        $shipper->delete();

        return response()->noContent();
    }
}
