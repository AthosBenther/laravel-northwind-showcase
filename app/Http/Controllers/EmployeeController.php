<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\Index;
use App\Http\Requests\Employee\Store;
use App\Http\Requests\Employee\Update;
use App\Models\Employee;

class EmployeeController extends NorthwindController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return Employee::paginate($request->per_page ?? 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $model = Employee::create($request->validated());

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $model)
    {
        return $model;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Employee $model)
    {
        $model->update($request->validated());

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $model)
    {
        $model->delete();

        return response()->noContent();
    }
}
