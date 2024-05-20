<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json($supplier, 201);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $supplier->update($validated);

        return response()->json($supplier, 200);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json(null, 204);
    }

    public function supplyProducts(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Loop through supplied products
        foreach ($validated['products'] as $product) {
            // Attach product to supplier with supplied quantity
            $supplier->products()->attach($product['product_id'], ['quantity' => $product['quantity']]);
            
            // Update available quantity of the product
            $productModel = Product::findOrFail($product['product_id']);
            $productModel->increment('available', $product['quantity']);
        }

        return response()->json(['message' => 'Products supplied successfully'], 201);
    }
}
