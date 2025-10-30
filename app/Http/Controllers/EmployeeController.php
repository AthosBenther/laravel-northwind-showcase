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
        $employee = Employee::create($request->validated());

        return $employee;
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Employee $employee)
    {
        $employee->update($request->validated());

        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->noContent();
    }
}
