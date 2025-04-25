@extends('layouts.master')
@section('title', 'Products')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Products</h2>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <form action="{{ route('products_list') }}" method="get" class="mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <label class="form-label">Search Products</label>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input class="form-control" type="text" placeholder="Product name" name="keywords" value="{{ request()->keywords }}"/>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search me-1"></i>Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Filter options -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Filter Options</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid">
                            <a href="{{ route('products_list') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle me-1"></i>Reset Filters
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <!-- Product Grid -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="card h-100 product-card shadow-sm">
                                <div class="position-absolute top-0 end-0 p-3">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                                
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                                    @if($product->photo)
                                        <img src="{{ asset('storage/products/' . $product->photo) }}" 
                                            class="card-img-top p-3" alt="{{ $product->name }}"
                                            style="height: 200px; object-fit: contain;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="card-body">
                                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                        <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                                    </a>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->model }}</h6>
                                    <p class="card-text small text-muted mb-1">Code: {{ $product->code }}</p>
                                    <p class="card-text description-text">{{ Str::limit($product->description, 100) }}</p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($product->stock_quantity > 10)
                                                <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="badge bg-warning text-dark">Low Stock ({{ $product->stock_quantity }})</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Comments count badge -->
                                        @if($product->comments->count() > 0)
                                            <span class="badge bg-info">
                                                <i class="bi bi-chat-text me-1"></i>{{ $product->comments->count() }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div>
                                            <span class="text-muted">Stock: {{ $product->stock_quantity }}</span>
                                        </div>
                                        <div>
                                            @if(auth()->user() && auth()->user()->hasPermissionTo('edit_products'))
                                                <a href="{{ route('products_edit', $product) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                @if(auth()->user()->hasPermissionTo('delete_products'))
                                                    <a href="{{ route('products_delete', $product) }}" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($product->stock_quantity < 1)
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-outline-secondary" disabled>Out of Stock</button>
                                        </div>
                                    @elseif(auth()->user() && auth()->user()->credits < $product->price)
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-outline-danger" disabled>Insufficient Credits</button>
                                        </div>
                                    @else
                                        <form action="{{ route('orders.place') }}" method="post" class="mt-3">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="input-group input-group-sm flex-grow-1">
                                                    <span class="input-group-text">Qty</span>
                                                    <input type="number" class="form-control" name="quantity" value="1" min="1"
                                                              max="{{ $product->stock_quantity }}" 
                                                              aria-label="Quantity">
                                                </div>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                No products found. Try adjusting your filters.
                            </div>
                        </div>
                    @endforelse
                </div>

                @if(auth()->user() && auth()->user()->hasPermissionTo('add_products'))
                <div class="mt-4 text-center">
                    <a href="{{ route('products_edit') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Add New Product
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .description-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
