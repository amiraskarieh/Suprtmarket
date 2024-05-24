<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'age' => 'required|integer',
            'salary' => 'required|numeric',
            'marital_status' => 'required',
            'job_type' => 'required',
            'employment_date' => 'required',
        ]);

        $user = User::find($request->user_id);
        if (!is_null($user->userable_type)) {
            return response()->json(['message' => "the user hase type"], 400);
        }
        $employee = Employee::create($validated);

        return response()->json($employee->id, 201);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:15',
            'age' => 'sometimes|required|integer',
            'salary' => 'sometimes|required|numeric',
            'employment_date' => 'sometimes|required|date',
            'marital_status' => 'required',
            'job_type' => 'required',
        ]);

        $employee->update($validated);
        return response()->json('', 201);
    }

    public function destroy(Employee $employee)
    {
        $employee->user()->delete();
        $employee->delete();
        return response()->json('', 201);
    }
}
