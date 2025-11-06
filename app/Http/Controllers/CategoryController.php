<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\Index;
use App\Http\Requests\Category\Store;
use App\Http\Requests\Category\Update;
use App\Models\Category;

class CategoryController extends NorthwindController
{
    /**
     * Lists the Category resources.
     */
    public function index(Index $request): CategoryCollection
    {
        return new CategoryCollection(Category::paginate($request->per_page ?? 5));
    }

    /**
     * Creates a new Category.
     */
    public function store(Store $request): CategoryResource
    {
        $category = Category::create($request->validated());

        return new  CategoryResource($category);
    }

    /**
     * Display the specified Category.
     */
    public function show(Category $category): CategoryResource
    {
        return new  CategoryResource($category);
    }

    /**
     * Update the specified Category.
     */
    public function update(Update $request, Category $category): CategoryResource
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    /**
     * Destroys the specified Category.
     */
    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
