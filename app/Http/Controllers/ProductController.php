<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('max_sell_price')) {
            $query->where('sell_price', '<=', $request->input('max_sell_price'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::create($validated);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $product->id . '.png';
            $image->move(public_path('/images/products'), $imageName);
        }

        return Inertia::render('Employee', ['product' => $product]);
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

        return Inertia::render('Employee', ['product' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::delete(public_path('/images/products/'.$id.'.png'));
        $product->delete();

        return Inertia::render('Employee');
    }

    public function getProductSales(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        $salesCount = Transaction::whereHas('products', function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            })
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('products.count');

        return response()->json([
            'product_id' => $product_id,
            'sales_between_dates' => $salesCount,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);
    }
}
