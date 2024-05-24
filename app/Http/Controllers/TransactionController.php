<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductTransactions;
use App\Models\Transaction;
use Illuminate\Validation\ValidationException;
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
            'products.*.count' => 'required|integer|min:1',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        if ($employee->job_type != 'cashier') { // Assuming job_type_id 1 is for cashier
            throw ValidationException::withMessages([
                'employee_id' => 'The employee must be a cashier.'
            ]);
        }

        $transaction = Transaction::create($validated);


        foreach ($validated['products'] as $product) {
            $productModel = Product::findOrFail($product['product_id']);
            if ($productModel->available < $product['count']) {
                return response()->json(['error' => 'Not enough count available for ' . $productModel->name], 400);
            }
            ProductTransactions::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productModel->id,
                'count' => $product['count'],
            ]);

            $productModel->decrement('available', $product['count']);
        }

        return response()->json(['message' => 'Products supplied successfully'], 201);
    }


    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.get');
    }
}
