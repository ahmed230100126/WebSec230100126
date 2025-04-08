@extends('layouts.master')
@section('title', 'Insufficient Balance')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Insufficient Balance</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger mb-4">
                        <h4 class="alert-heading">Your balance is not enough.</h4>
                        <p>You don't have enough credits to complete this purchase.</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Your Balance</h5>
                                    <h3 class="text-primary">${{ number_format($user->credits, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Product Cost</h5>
                                    <h3 class="text-danger">${{ number_format($total, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Shortage</h5>
                                    <h3 class="text-danger">${{ number_format($total - $user->credits, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3">Product Details:</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $quantity }}</td>
                                    <td>${{ number_format($total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('products_list') }}" class="btn btn-primary">
                            <i class="bi bi-cart me-1"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
