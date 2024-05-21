<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['customer', 'employee', 'products'])->get();
        return Inertia::render('Transactions', [
            'transactions' => $transactions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Ensure the employee is of type cashier
        $employee = Employee::findOrFail($validated['employee_id']);
        if ($employee->job_type_id != 1) { // Assuming job_type_id 1 is for cashier
            throw ValidationException::withMessages([
                'employee_id' => 'The employee must be a cashier.'
            ]);
        }

        $transaction = Transaction::create([
            'customer_id' => $validated['customer_id'],
            'employee_id' => $validated['employee_id'],
        ]);


        // Attach products to transaction
        foreach ($validated['products'] as $product) {
            $productModel = Product::findOrFail($product['product_id']);
            if ($productModel->available < $product['quantity']) {
                return response()->json(['error' => 'Not enough quantity available for ' . $productModel->name], 400);
            }

            $transaction->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
            
            // Update available quantity
            $productModel->decrement('available', $product['quantity']);
        }

        return response()->json($transaction->load('products'), 201);
    }

   
       // Delete a transaction
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(null, 204);
    }
}
