<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return Inertia::render('Suppliers/Index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $supplier = Supplier::create($validated);

        return redirect()->route('suppliers.get');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.get');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.get');
    }

    public function supplyProducts(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($validated['products'] as $product) {
            $supplier->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
            
            $productModel = Product::findOrFail($product['product_id']);
            $productModel->increment('available', $product['quantity']);
        }

        return response()->json(['message' => 'Products supplied successfully'], 201);
    }
}
