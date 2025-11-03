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
        return Product::paginate($request->per_page ?? 5)->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $product = Product::create($request->validated());

        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Product $product)
    {
        $product->update($request->validated());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
