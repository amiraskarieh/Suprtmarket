<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        Supplier::create($validated);

        return response()->json('{}',201);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $supplier->update($validated);

        return response()->json('{}',201);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json('{}',201);
    }

    public function supplyProducts(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.count' => 'required|integer|min:1',
        ]);

        foreach ($validated['products'] as $product) {
            $supplier->products()->attach($product['product_id'], ['count' => $product['count']]);

            $productModel = Product::findOrFail($product['product_id']);
            $productModel->increment('available', $product['count']);
        }

        return response()->json(['message' => 'Products supplied successfully'], 201);
    }
}
