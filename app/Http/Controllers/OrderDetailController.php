<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderDetail\Index;
use App\Http\Requests\OrderDetail\Store;
use App\Http\Requests\OrderDetail\Update;
use App\Models\OrderDetail;

class OrderDetailController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return OrderDetail::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $model = OrderDetail::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, OrderDetail $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetail $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
