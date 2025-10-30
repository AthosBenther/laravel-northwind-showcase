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
        $orderDetail = OrderDetail::create($request->validated());

        return $orderDetail;
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $orderDetail)
    {
        return $orderDetail;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, OrderDetail $orderDetail)
    {
        $orderDetail->update($request->validated());

        return $orderDetail;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetail $orderDetail)
    {
        $orderDetail->delete();

        return response()->noContent();
    }
}
