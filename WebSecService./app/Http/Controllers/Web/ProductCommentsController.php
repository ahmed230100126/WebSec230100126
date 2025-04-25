<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ProductCommentsController extends Controller
{
    /**
     * Store a new product comment
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Check if user has purchased this product
        $hasPurchased = auth()->user()
            ->orders()
            ->whereHas('items', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists(); // Removed the status check to allow comments regardless of order status
        
        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'You can only review products you have purchased.');
        }

        $comment = new ProductComment();
        $comment->product_id = $product->id;
        $comment->user_id = auth()->id();
        $comment->comment = $request->comment;
        $comment->rating = $request->rating;
        $comment->save();
        
        return redirect()->back()->with('success', 'Your comment has been added.');
    }
    
    /**
     * Delete a product comment
     */
    public function destroy(ProductComment $comment)
    {
        // Check if the user is authorized to delete this comment
        if (auth()->id() != $comment->user_id && !auth()->user()->hasPermissionTo('delete_comments')) {
            abort(403, 'Unauthorized action.');
        }
        
        $product = $comment->product;
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment has been deleted.');
    }
}
