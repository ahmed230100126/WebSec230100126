@extends('layouts.master')
@section('title', 'Products')
@section('content')

<div class="card m-4">
    <div class="card-header">
        <h1>Products</h1>
    </div>
    <div class="card-body">
        <form method="get" action="{{ route('products_list') }}">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input class="form-control" placeholder="Filter by name" name="keywords" value="{{ request()->keywords }}"/>
                </div>
                <div class="col-md-3">
                    <input class="form-control" type="number" step="0.01" placeholder="Min Price" name="min_price" value="{{ request()->min_price }}"/>
                </div>
                <div class="col-md-3">
                    <input class="form-control" type="number" step="0.01" placeholder="Max Price" name="max_price" value="{{ request()->max_price }}"/>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Model</th>
                        <th>Price</th>
                        <th>Description</th>
                        @auth
                            @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                                <th>Stock</th>
                                <th>Actions</th>
                            @endif
                        @endauth
                        @auth
                            @if(auth()->user()->hasRole('Customer'))
                                <th>Available</th>
                                <th>Buy</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->model }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->description }}</td>
                        @auth
                            @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                                <td>{{ $product->stock_quantity }}</td>
                                <td>
                                    <a href="{{ route('products_edit', $product) }}" class="btn btn-sm btn-primary">Edit</a>

                                    @if(auth()->user()->hasPermissionTo('delete_products'))
                                        <a href="{{ route('products_delete', $product) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                    @endif
                                </td>
                            @endif
                        @endauth
                        @auth
                            @if(auth()->user()->hasRole('Customer'))
                                <td>{{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                                <td>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-control form-control-sm" style="max-width: 70px">
                                            <button type="submit" class="btn btn-sm btn-success" {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                                                {{ $product->stock_quantity < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            @endif
                        @endauth
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @auth
            @if(auth()->user()->hasAnyRole(['Admin', 'Employee']))
                <div class="mt-3">
                    <a href="{{ route('products_edit') }}" class="btn btn-success">Add New Product</a>
                </div>
            @endif
        @endauth
    </div>
</div>

@endsection
