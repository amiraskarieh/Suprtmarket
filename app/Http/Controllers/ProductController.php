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

    public function getProductSalesLastNDays($product_id, $days)
    {
        $product = Product::findOrFail($product_id);

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays($days);

        $salesCount = Transaction::whereHas('products', function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            })
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('products.count');

        return response()->json(['product_id' => $product_id, 'sales_last_' . $days . '_days' => $salesCount]);
    }

    public function filteredProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }

        if ($request->has('min_sell_price')) {
            $query->where('sell_price', '>=', $request->input('min_sell_price'));
        }

        if ($request->has('max_sell_price')) {
            $query->where('sell_price', '<=', $request->input('max_sell_price'));
        }

        if ($request->has('min_buy_price')) {
            $query->where('buy_price', '>=', $request->input('min_buy_price'));
        }

        if ($request->has('max_buy_price')) {
            $query->where('buy_price', '<=', $request->input('max_buy_price'));
        }

        if ($request->has('min_sell_number')) {
            $query->where('sell_number', '>=', $request->input('min_sell_number'));
        }

        if ($request->has('max_sell_number')) {
            $query->where('sell_number', '<=', $request->input('max_sell_number'));
        }

        if ($request->has('is_perishable')) {
            $query->where('is_perishable', $request->input('is_perishable'));
        }

        if ($request->has('min_production_date')) {
            $query->where('production_date', '>=', $request->input('min_production_date'));
        }

        if ($request->has('max_production_date')) {
            $query->where('production_date', '<=', $request->input('max_production_date'));
        }

        if ($request->has('min_expiration_date')) {
            $query->where('expiration_date', '>=', $request->input('min_expiration_date'));
        }

        if ($request->has('max_expiration_date')) {
            $query->where('expiration_date', '<=', $request->input('max_expiration_date'));
        }

        if ($request->has('available')) {
            $query->where('available', $request->input('available'));
        }

        if ($request->has('sort_by')) {
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($request->input('sort_by'), $sortOrder);
        }

        $products = $query->get();

        return response()->json($products);
    }
}
