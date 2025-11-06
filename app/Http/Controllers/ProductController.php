<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\Index;
use App\Http\Requests\Product\Store;
use App\Http\Requests\Product\Update;
use App\Models\Product;

class ProductController extends NorthwindController
{
    /**
     * Lists the Product resources.
     */
    public function index(Index $request): ProductCollection
    {
        return new ProductCollection(Product::paginate($request->per_page ?? 5));
    }

    /**
     * Creates a new Product.
     */
    public function store(Store $request): ProductResource
    {
        $product = Product::create($request->validated());

        return new  ProductResource($product);
    }

    /**
     * Display the specified Product.
     */
    public function show(Product $product): ProductResource
    {
        return new  ProductResource($product);
    }

    /**
     * Update the specified Product.
     */
    public function update(Update $request, Product $product): ProductResource
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    /**
     * Destroys the specified Product.
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
