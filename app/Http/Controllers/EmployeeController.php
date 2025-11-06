<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\Employee\Index;
use App\Http\Requests\Employee\Store;
use App\Http\Requests\Employee\Update;
use App\Models\Employee;

class EmployeeController extends NorthwindController
{
    /**
     * Lists the Employee resources.
     */
    public function index(Index $request): EmployeeCollection
    {
        return new EmployeeCollection(Employee::paginate($request->per_page ?? 5));
    }

    /**
     * Creates a new Employee.
     */
    public function store(Store $request): EmployeeResource
    {
        $employee = Employee::create($request->validated());

        return new  EmployeeResource($employee);
    }

    /**
     * Display the specified Employee.
     */
    public function show(Employee $employee): EmployeeResource
    {
        return new  EmployeeResource($employee);
    }

    /**
     * Update the specified Employee.
     */
    public function update(Update $request, Employee $employee): EmployeeResource
    {
        $employee->update($request->validated());

        return new EmployeeResource($employee);
    }

    /**
     * Destroys the specified Employee.
     */
    public function destroy(Employee $employee): Response
    {
        $employee->delete();

        return response()->noContent();
    }
}
