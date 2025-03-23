@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Products</h2>
            @can('create_products')
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
            @endcan
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Price: ${{ number_format($product->price, 2) }}</strong></p>
                        <div class="btn-group">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info">View</a>
                            @can('edit_products')
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                            @endcan
                            @can('delete_products')
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection