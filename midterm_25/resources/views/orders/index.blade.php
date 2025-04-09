@extends('layouts.master')
@section('title', 'Orders')
@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">{{ Auth::user()->hasAnyRole(['Admin', 'Employee']) ? 'All Orders' : 'My Orders' }}</h1>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    {{ session('error') }}
                </div>
            @endif

            @if(count($orders) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                @if(Auth::user()->hasAnyRole(['Admin', 'Employee']))
                                    <th>Customer</th>
                                @endif
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    @if(Auth::user()->hasAnyRole(['Admin', 'Employee']))
                                        <td>{{ $order->user->name }}</td>
                                    @endif
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            Purchase Completed
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                        
                                        @if(Auth::user()->hasAnyRole(['Admin', 'Employee']) && $order->status !== 'Cancelled')
                                            <a href="{{ route('orders.cancel', $order->id) }}" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to cancel this order? This will refund the customer and restore stock.')">
                                                Cancel Order
                                            </a>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <a href="{{ route('order_delete', $order->id) }}" class="btn btn-sm btn-primary">Delete</a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No orders found.
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('products_list') }}" class="btn btn-success">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection
