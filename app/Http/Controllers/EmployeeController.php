<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return Inertia::render('Employees', [
            'employees' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:employees,phone',
            'age' => 'required|integer|min:0',
            'salary' => 'required|numeric|min:0',
            'employment_date' => 'required|date',
            'marital_status_id' => 'required|exists:marital_statuses,id',
            'job_type_id' => 'required|exists:job_types,id',
        ]);

        $employee = Employee::create($validated);

        return redirect()->route('employees.get');
    }

    // Update an existing employee
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:15|unique:employees,phone,' . $id,
            'age' => 'sometimes|required|integer|min:0',
            'salary' => 'sometimes|required|numeric|min:0',
            'employment_date' => 'sometimes|required|date',
            'marital_status_id' => 'sometimes|required|exists:marital_statuses,id',
            'job_type_id' => 'sometimes|required|exists:job_types,id',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($validated);

        return redirect()->route('employees.get');
    }

    // Delete an employee
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.get');
    }
}
