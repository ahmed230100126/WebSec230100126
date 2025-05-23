<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
        $this->middleware('auth:web')->except('list');
    }

	public function list(Request $request) {

		$query = Product::select("products.*");

		
		if ($request->keywords) {
			 $rawProducts = DB::select("SELECT * FROM products WHERE name LIKE '%" . $request->keywords . "%'");
			

			$collection = collect($rawProducts);
			$productIds = $collection->pluck('id')->toArray();
			$products = Product::with('comments.user', 'likes')->whereIn('id', $productIds)->get();
			
			return view('products.list', compact('products'));
		}

		$query->when($request->min_price,
		fn($q)=> $q->where("price", ">=", $request->min_price));

		$query->when($request->max_price, fn($q)=>
		$q->where("price", "<=", $request->max_price));

		$query->when($request->order_by,
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		// For customers, only show products with stock > 0
		if (auth()->check() && auth()->user()->hasRole('Customer')) {
			$query->where('stock_quantity', '>', 0);
		}

		$products = $query->get();

		// Load comments for all products
		$products->load('comments.user');

		return view('products.list', compact('products'));
	}

	public function edit(Request $request, Product $product = null) {
		// Check if user has permission to edit products
		if(!auth()->user()->hasPermissionTo('edit_products')) abort(401);

		$product = $product??new Product();

		return view('products.edit', compact('product'));
	}

	public function save(Request $request, Product $product = null) {
		// Check if user has permission to add or edit products
		if(!auth()->user()->hasAnyPermission(['add_products', 'edit_products'])) abort(401);

		$this->validate($request, [
	        'code' => ['required', 'string', 'max:32'],
	        'name' => ['required', 'string', 'max:128'],
	        'model' => ['required', 'string', 'max:256'],
	        'description' => ['required', 'string', 'max:1024'],
	        'price' => ['required', 'numeric'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
	    ]);

		$product = $product??new Product();
		$product->fill($request->all());
		$product->save();

		return redirect()->route('products_list');
	}

	public function delete(Request $request, Product $product) {
		// Check if user has permission to delete products
		if(!auth()->user()->hasPermissionTo('delete_products')) abort(401);

		$product->delete();

		return redirect()->route('products_list');
	}

	/**
	 * Reset product stock to zero
	 */
	public function resetStock(Product $product)
	{
	    // Check if user has permission (should be Employee or Admin)
	    if (!auth()->user()->hasAnyRole(['Admin', 'Employee'])) {
	        abort(403, 'Unauthorized action.');
	    }
	    
	    // Reset stock to zero
	    $product->stock_quantity = 0;
	    $product->save();
	    
	    return redirect()->route('products_list')
	        ->with('success', "Stock for {$product->name} has been reset to 0.");
	}

	/**
	 * Display a single product with comments
	 */
	public function show(Product $product) 
	{
		// Load the product with comments and their authors
		$product->load(['comments.user']);
		
		return view('products.show', compact('product'));
	}

	/**
	 * Toggle favorite status for a product
	 */
	public function toggleFavorite(Product $product)
	{
		// Check if user has permission to favorite products
		if(!auth()->user()->hasPermissionTo('favorite_product')) {
			abort(403, 'Unauthorized action.');
		}

		$favorite = $product->toggleFavorite();
		$message = $favorite ? 'Product added to favorites' : 'Product removed from favorites';

		return redirect()->back()->with('success', $message);
	}
}
