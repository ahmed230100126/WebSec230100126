@extends('layouts.master')
@section('title', 'Order Details')
@section('content')
<div class="container py-5">
    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-3 mb-4 border-0">
                <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h3 class="mb-0 fw-bold">Order #{{ $order->id }}</h3>
                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'delivered' ? 'success' : 'info') }} fs-6 px-3 py-2">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary fw-bold"><i class="bi bi-calendar3 me-2"></i>Order Date</h5>
                            <p class="ms-4">{{ $order->created_at->format('F j, Y g:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary fw-bold"><i class="bi bi-person-fill me-2"></i>Customer</h5>
                            <p class="ms-4">{{ $order->user->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary fw-bold"><i class="bi bi-truck me-2"></i>Shipping Address</h5>
                            <p class="ms-4">{{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary fw-bold"><i class="bi bi-credit-card me-2"></i>Billing Address</h5>
                            <p class="ms-4">{{ $order->billing_address }}</p>
                        </div>
                    </div>

                    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-box-seam me-2"></i>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="fw-medium">{{ $item->product->name }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="table-active">
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="text-end fw-bold text-primary fs-5">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-gradient bg-primary text-white py-3">
                    <h3 class="mb-0 fw-bold"><i class="bi bi-gear-fill me-2"></i>Order Actions</h3>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        {{-- <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to Orders
                        </a> --}}
                        <a href="{{ route('products_list') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-cart-plus me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm rounded-3 border-0 mt-4">
                <div class="card-body p-4 bg-light">
                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i>Need Help?</h5>
                    <p>If you have questions about your order, please contact our customer support team.</p>
                    <a href="#" class="btn btn-outline-primary"><i class="bi bi-headset me-2"></i>Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
