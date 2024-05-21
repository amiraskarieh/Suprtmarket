<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'phone' => 'required|string|unique:customers,phone|max:15',
            'address' => 'required|string|max:255',
        ]);

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    // Update an existing customer
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer|min:0',
            'phone' => 'sometimes|required|string|unique:customers,phone,' . $id . '|max:15',
            'address' => 'sometimes|required|string|max:255',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        return response()->json($customer, 200);
    }

    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(null, 204);
    }
}
