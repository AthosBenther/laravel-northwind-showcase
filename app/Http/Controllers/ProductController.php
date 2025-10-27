<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Index;
use App\Http\Requests\Product\Store;
use App\Http\Requests\Product\Update;
use App\Models\Product;

class ProductController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Product::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $model = Product::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Product $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
