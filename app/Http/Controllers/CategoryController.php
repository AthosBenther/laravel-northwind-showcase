<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\Index;
use App\Http\Requests\Category\Store;
use App\Http\Requests\Category\Update;
use App\Models\Category;

class CategoryController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Category::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $model = Category::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Category $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
