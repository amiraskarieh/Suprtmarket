<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Products', [
            'products' => $products,
        ]); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sell_number' => 'required|integer',
            'buy_price' => 'required|numeric',
            'available' => 'required|numeric',
            'discount' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'production_date' => 'required|date',
            'expiration_date' => 'nullable|date',
            'is_perishable' => 'required|boolean',
        ]);

        if ($validated['is_perishable'] && empty($validated['expiration_date'])) {
            throw ValidationException::withMessages([
                'expiration_date' => 'The expiration date is required for perishable products.',
            ]);
        }

        $product = Product::create($validated);

        return redirect()->route('products.get');
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'sell_number' => 'sometimes|required|integer',
            'buy_price' => 'sometimes|required|numeric',
            'available' => 'sometimes|required|boolean',
            'discount' => 'sometimes|required|numeric',
            'sell_price' => 'sometimes|required|numeric',
            'production_date' => 'sometimes|required|date',
            'expiration_date' => 'nullable|date',
            'is_perishable' => 'sometimes|required|boolean',
        ]);

        // Custom validation logic
        if (isset($validated['is_perishable']) && $validated['is_perishable'] && empty($validated['expiration_date'])) {
            throw ValidationException::withMessages([
                'expiration_date' => 'The expiration date is required for perishable products.',
            ]);
        }

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('products.get');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.get');
    }
}
