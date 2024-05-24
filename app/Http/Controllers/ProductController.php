<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sell_number' => 'required',
            'buy_price' => 'required',
            'discount' => 'required',
            'sell_price' => 'required',
            'production_date' => 'required',
            'perishable_data' => 'nullable',
            'is_perishable' => 'required',
            'available' => 'required',
            'supplier_id' => 'required',
        ]);

        Product::create($validated);

        return response()->json('{}',201);
    }

    public function update(Request $request,Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sell_number' => 'required',
            'buy_price' => 'required',
            'discount' => 'required',
            'sell_price' => 'required',
            'production_date' => 'required',
            'perishable_data' => 'nullable',
            'is_perishable' => 'required',
            'available' => 'required',
            'supplier_id' => 'required',
        ]);

        $product->update($validated);

        return $this->index();
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->index();
    }
}
