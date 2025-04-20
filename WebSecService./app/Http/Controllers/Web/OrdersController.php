<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->except(['index']);
    }

    /**
     * Display a listing of the customer's orders.
     */
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If employee or admin, show all orders
        if ($user->hasAnyRole(['Admin', 'Employee'])) {
            $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
            return view('orders.index', compact('orders'));
        }

        // For customers, only show their orders
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        // Check if user has permission to view this order
        $user = Auth::user();
        if (!$user->hasAnyRole(['Admin', 'Employee']) && $order->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('items.product', 'user');
        return view('orders.show', compact('order'));
    }

    /**
     * to complet the order and process payment 
     */
    public function placeOrder(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Get the product outside of the transaction first to check balance
        $product = Product::find($productId);
        
        if (!$product) {
            return redirect()->route('products_list')->with('error', 'Product not found.');
        }
        
        // Calculate total cost
        $total = $product->price * $quantity;
        
        // Check if user has enough balance before starting transaction
        if ($user->credits < $total) {
            // Redirect to the insufficient balance page with details
            return view('orders.insufficient_balance', compact('user', 'product', 'quantity', 'total'));
        }

        // Use a database transaction to ensure atomicity
        return DB::transaction(function() use ($productId, $quantity, $user) {
            $product = Product::lockForUpdate()->find($productId);

            if (!$product) {
                DB::rollBack();
                return redirect()->route('products_list')->with('error', 'Product not found.');
            }

            // Check if product is in stock
            if ($product->stock_quantity < $quantity) {
                DB::rollBack();
                return redirect()->route('products_list')->with('error', 'Not enough stock available.');
            }
        
            // Calculate total
            $total = $product->price * $quantity;

            // Check if user has enough credits (redundant check, but kept for safety)
            if ($user->credits < $total) {
                DB::rollBack();
                return view('orders.insufficient_balance', compact('user', 'product', 'quantity', 'total'));
            }

            // Create order
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_amount = $total;
            $order->status = 'Purchase Completed';
            $order->save();

            // Create order item
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->id;
            $orderItem->quantity = $quantity;
            $orderItem->price = $product->price;
            $orderItem->save();

            // Update product stock
            $product->stock_quantity -= $quantity;
            $product->save();

            // Deduct credits from user account
            $user->deductCredits($total);

            return redirect()->route('orders.show', $order->id)->with('success', 'Your order has been placed successfully! Order #' . $order->id);
        });
    }


    /**
     * List all customers (for employees)
     */
    public function listCustomers()
    {
        // Check if user has permission
        if (!Auth::user()->hasPermissionTo('list_customers')) {
            abort(403, 'Unauthorized action.');
        }

        $customers = User::role('Customer')->get();
        return view('users.customers', compact('customers'));
    }

    /**
     * Add credits to customer (for employees and admins)
     */
    public function addCreditsForm(User $user)
    {
        // Check permissions
        if (!Auth::user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure target user is a customer
        if (!$user->hasRole('Customer')) {
            return redirect()->back()->with('error', 'Credits can only be added to customer accounts.');
        }

        return view('users.add_credits', compact('user'));
    }

    /**
     * Process adding credits to a customer
     */
    public function addCredits(Request $request, User $user)
    {
        // Check permissions
        if (!Auth::user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(403, 'Unauthorized action.');
        }

        // Validate request
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        // Ensure target user is a customer
        if (!$user->hasRole('Customer')) {
            return redirect()->back()->with('error', 'Credits can only be added to customer accounts.');
        }

        // Add credits
        $user->addCredits($request->amount);

        return redirect()->route('list_customers')
            ->with('success', "Successfully added {$request->amount} credits to {$user->name}'s account.");
    }

    public function delete(Request $request, Order $order)
    {
        // Check if user has permission to delete orders
        if (!auth()->user()->hasPermissionTo('manage_orders')) {
            abort(401);
        }
        $order->delete();

        return redirect()->route('orders.index');
    }
}
