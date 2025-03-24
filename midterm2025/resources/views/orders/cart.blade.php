@extends("layouts.master")
@section("title", "Shopping Cart")
@section("content")
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Your Shopping Cart</h2>
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

            @if(session('warning'))
                <div class="alert alert-warning mb-3">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    @if(count($cart) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>${{ number_format($item['price'], 2) }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Your cart is empty. <a href="{{ route('products_list') }}">Browse products</a> to add items to your cart.
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h4 class="mb-0">Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Total:</h5>
                                <h5>${{ number_format($total, 2) }}</h5>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <h5>Your Credits:</h5>
                                <h5>${{ number_format($user->credits, 2) }}</h5>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-3">
                                <h5>Balance After Purchase:</h5>
                                <h5 class="{{ $user->credits >= $total ? 'text-success' : 'text-danger' }}">
                                    ${{ number_format($user->credits - $total, 2) }}
                                </h5>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ route('products_list') }}" class="btn btn-secondary">Continue Shopping</a>
                                @if(count($cart) > 0)
                                    <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
