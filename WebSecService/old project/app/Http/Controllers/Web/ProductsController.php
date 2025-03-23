<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Spatie\Permission\Models\Permission;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

    public function list(Request $request)
    {
        $query = Product::select("products.*");
        $query->when($request->keywords, fn($q) => $q->where("name", "like", "%$request->keywords%"));
        $query->when($request->min_price, fn($q) => $q->where("price", ">=", $request->min_price));
        $query->when($request->max_price, fn($q) => $q->where("price", "<=", $request->max_price));
        $query->when($request->order_by, fn($q) => $q->orderBy($request->order_by, $request->order_direction ?? "ASC"));
        $products = $query->get();
        return view('products.list', compact('products'));
    }

    public function edit($product = null)
    {
        if (!$this->canEditProducts()) {
            return redirect()->route('products_list')->with('error', 'You do not have permission to edit products.');
        }

        $product = $product ? Product::findOrFail($product) : new Product();
        return view('products.edit', compact('product'));
    }

    public function save(Request $request, $product = null)
    {
        if (!$this->canEditProducts()) {
            return redirect()->route('products_list')->with('error', 'You do not have permission to edit products.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'code' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'photo' => 'required|string|max:255',
        ]);

        $product = $product ? Product::findOrFail($product) : new Product();
        
        // Generate a unique code for new products if not provided
        if (!$product->exists && !$request->has('code')) {
            $request->merge(['code' => 'PRD-' . strtoupper(uniqid())]);
        }

        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }

    public function delete($product)
    {
        if (!$this->canDeleteProducts()) {
            return redirect()->route('products_list')->with('error', 'You do not have permission to delete products.');
        }

        $product = Product::findOrFail($product);
        $product->delete();

        return redirect()->route('products_list')->with('success', 'Product deleted successfully.');
    }

    private function canEditProducts()
    {
        return auth()->user()->can('update_products') || auth()->user()->can('create_products');
    }

    private function canDeleteProducts()
    {
        return auth()->user()->can('delete_products');
    }
}
