<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\Employee\Index;
use App\Http\Requests\Employee\Store;
use App\Http\Requests\Employee\Update;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $data = $request->validated();
        unset($data['Photo']);
        $employee = Employee::create($data);

        if ($request->hasFile('Photo')) {
            $file = $request->file('Photo');

            // Save binary blob to DB
            $employee->Photo = file_get_contents($file->getRealPath());

            // Generate random file name
            $randomName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store file on disk
            $path = $file->storeAs(
                "images/employees",
                $randomName,
                'public'
            );

            // Store the storage path (or public URL)
            $employee->PhotoPath = Storage::url($path);
        } else
            $employee->Photo = null;

        $employee->save();

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified Employee.
     */
    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified Employee.
     */
    public function update(Update $request, Employee $employee): EmployeeResource
    {
        $data = $request->validated();
        unset($data['Photo']);
        $employee->update($data);

        if ($request->hasFile('Photo')) {
            $file = $request->file('Photo');

            // Save binary blob to DB
            $employee->Photo = file_get_contents($file->getRealPath());

            // Generate random file name
            $randomName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store file on disk
            $path = $file->storeAs(
                "images/employees",
                $randomName,
                'public'
            );

            // Store the storage path (or public URL)
            $employee->PhotoPath = Storage::url($path);
        } else
            $employee->Photo = null;

        $employee->save();

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
