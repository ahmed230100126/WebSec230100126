/**
     * Cancel an order, refund the customer, and restore stock
     */
    // public function cancelOrder(Order $order)
    // {
    //     // Check if user has permission (should be Employee or Admin)
    //     if (!auth()->user()->hasAnyRole(['Admin', 'Employee'])) {
    //         abort(403, 'Unauthorized action.');
    //     }
        
    //     // Use a transaction to ensure all operations complete successfully
    //     return DB::transaction(function() use ($order) {
    //         // Load order with its items if not already loaded
    //         if (!$order->relationLoaded('items')) {
    //             $order->load('items.product', 'user');
    //         }
            
    //         // Check if order is already cancelled
    //         if ($order->status === 'Cancelled') {
    //             return redirect()->route('orders.index')
    //                 ->with('error', "Order #{$order->id} is already cancelled.");
    //         }
            
    //         // Restore stock for each item
    //         foreach ($order->items as $item) {
    //             $product = $item->product;
    //             $product->stock_quantity += $item->quantity;
    //             $product->save();
    //         }
            
    //         // Refund the customer
    //         $user = $order->user;
    //         $user->credits += $order->total_amount;
    //         $user->save();
            
    //         // Update order status
    //         $order->status = 'Cancelled';
    //         $order->save();
            
    //         return redirect()->route('orders.index')
    //             ->with('success', "Order #{$order->id} has been cancelled and ${$order->total_amount} has been refunded to {$user->name}.");
    //     });
    // }