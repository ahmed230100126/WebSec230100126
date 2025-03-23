@extends('layouts.master')
@section('title', 'Products')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Products</h1>
        @can('create_products')
            <a href="{{ route('products_edit') }}" class="btn btn-primary">Add New Product</a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products_list') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
                    </div>
                    <div class="col-md-2">
                        <input name="min_price" type="number" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
                    </div>
                    <div class="col-md-2">
                        <input name="max_price" type="number" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
                    </div>
                    <div class="col-md-2">
                        <select name="order_by" class="form-select">
                            <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                            <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                            <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="order_direction" class="form-select">
                            <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                            <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                            <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">Search</button>
                            <a href="{{ route('products_list') }}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">
                            <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>
                            <strong>Stock:</strong> {{ $product->stock }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            @can('update_products')
                                <a href="{{ route('products_edit', $product->id) }}" class="btn btn-outline-primary">Edit</a>
                            @endcan
                            @can('delete_products')
                                <a href="{{ route('products_delete', $product->id) }}" 
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
