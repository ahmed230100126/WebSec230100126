<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLike;
use Illuminate\Http\Request;

class ProductLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Toggle like/unlike for a product
     */
    public function toggleLike(Product $product)
    {
        $user = auth()->user();
        
        $existingLike = ProductLike::where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->first();
        
        if ($existingLike) {
            // Unlike if already liked
            $existingLike->delete();
            $message = 'Product removed from your likes';
        } else {
            // Like the product
            ProductLike::create([
                'product_id' => $product->id,
                'user_id' => $user->id
            ]);
            $message = 'Product added to your likes';
        }
        
        return redirect()->back()->with('success', $message);
    }
}
